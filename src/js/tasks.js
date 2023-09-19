// Normally if you don't put the code inside that function it would work if you call if from another .js archive that's called on the side, by doing this you protect it so it only works when used on this archive

(function() {

    obtainTasks();
    let tasks = [];
    let filtered = [];

    // Button to show the form to add task

    const newTaskBtn = document.querySelector("#add-task");
    newTaskBtn.addEventListener("click", function() {
        showForm();
    });

    // Search Filters

    const filters = document.querySelectorAll("#filters input[type='radio']");

    filters.forEach(radio => {
        radio.addEventListener("input", filterTasks)
    });

    function filterTasks(e) {
        const filter = e.target.value;

        if(filter !== "") {
            filtered = tasks.filter(task => task.status === filter);
        } else {
            filtered = [];
        }

        showTasks();
    }

    async function obtainTasks() {
        try {
            const id = obtainProject();
            const url = `/api/tasks?id=${id}`

            // This waits until the connection with the url has been made before continuing executing code

            const answer = await fetch(url);

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const result = await answer.json();
            tasks = result.tasks;
            showTasks();
        } catch (error) {
            console.log(error);
        }
    }

    function showTasks() {
        cleanTasks();
        totalPending();
        totalComplete();

        // This is a ternary, if filtered has something then tasksArray equals filtered and if not equals tasks

        const tasksArray = filtered.length ? filtered : tasks;

        if(tasksArray.length === 0) {
            const tasksList = document.querySelector("#tasks-list");
            const textNoTasks = document.createElement("LI");
            textNoTasks.textContent = "There are no tasks";
            textNoTasks.classList.add("no-tasks");
            tasksList.appendChild(textNoTasks);
            return;
        }

        const statuses = {
            0: "Pending",
            1: "Complete"
        }

        tasksArray.forEach(task => {
            const taskContainer = document.createElement("LI");
            taskContainer.dataset.taskId = task.id;
            taskContainer.classList.add("task");

            const taskName = document.createElement("P");
            taskName.textContent = task.name;
            taskName.ondblclick = function() {

                // Makes and sends a copy of the task in question, change it and then save it in the original, if you don't do this it can lead to errors down the line, because you are mutating the original object

                // That's using something called a "spread operator"

                showForm(edit = true, {...task});
            }


            const divOptions = document.createElement("DIV");
            divOptions.classList.add("options");

            // Buttons

            const btnTaskStatus = document.createElement("BUTTON");
            btnTaskStatus.classList.add("task-status");
            btnTaskStatus.classList.add(`${statuses[task.status].toLowerCase()}`);
            btnTaskStatus.textContent = statuses[task.status];
            btnTaskStatus.dataset.taskStatus = task.status;
            btnTaskStatus.ondblclick = function() {

                // Makes and sends a copy of the task in question, change it and then save it in the original, if you don't do this it can lead to errors down the line, because you are mutating the original object

                // That's using something called a "spread operator"

                changeTaskStatus({...task});
            }


            const btnDeleteTask = document.createElement("BUTTON");
            btnDeleteTask.classList.add("delete-task");
            btnDeleteTask.dataset.taskId = task.id;
            btnDeleteTask.textContent = "Delete";
            btnDeleteTask.ondblclick = function() {

                // Makes and sends a copy of the task in question, change it and then save it in the original, if you don't do this it can lead to errors down the line, because you are mutating the original object

                // That's using something called a "spread operator"

                confirmDeleteTask({...task});
            }

            divOptions.appendChild(btnTaskStatus);
            divOptions.appendChild(btnDeleteTask);

            taskContainer.appendChild(taskName);
            taskContainer.appendChild(divOptions);

            const tasksList = document.querySelector("#tasks-list");
            tasksList.appendChild(taskContainer);
        });
    }

    function totalPending() {
        const totalPending = tasks.filter(task => task.status === "0");
        const pedingRadio = document.querySelector("#pending");
        const completeRadio = document.querySelector("#complete");

        if(totalPending.length === 0) {
            pedingRadio.disabled = true;
            completeRadio.checked = true;
        } else {
            pedingRadio.disabled = false;
        }
    }

    function totalComplete() {
        const totalComplete = tasks.filter(task => task.status === "1");
        const pedingRadio = document.querySelector("#pending");
        const completeRadio = document.querySelector("#complete");

        if(totalComplete.length === 0) {
            pedingRadio.checked = true;
            completeRadio.disabled = true;
        } else {
            completeRadio.disabled = false;
        }
    }

    function showForm(edit = false, task = {}) {
        const modal = document.createElement("DIV");
        modal.classList.add("modal");
        modal.innerHTML= `
            <form class="form new-task">
                <legend>${edit ? "Edit task" : "Add a new task"}</legend>
                <div class="field">
                    <label>Task Name</label>
                    <input type="text" name="task" placeholder="${task.name ? "Edit the name of the task" : "Name of the new task"}" id="task" value="${task.name ? task.name : ""}"/>
                </div>
                <div class="options">
                    <input type="submit" class="submit-new-task" value="${task.name ? "Save Changes" : "Add Task"}"/>
                    <button type="button" class="close-modal">Cancel</button>
                </div>
            </form>
        `;

        setTimeout(() => {
            const form = document.querySelector(".form");
            form.classList.add("animate");
        }, 100);

        modal.addEventListener("click", function(e){

            // This is so the submit doesn't refresh the page

            e.preventDefault();

            if(e.target.classList.contains("close-modal") || e.target.classList.contains("modal")) {
                const form = document.querySelector(".form");
                form.classList.add("close");

                setTimeout(() => {
                    modal.remove();
                }, 500);
            }

            if(e.target.classList.contains("submit-new-task")) {
                // .trim() is to delete spaces before and after the value of the object

                const taskName = document.querySelector("#task").value.trim();

                if(taskName === "") {

                    // Show an error alert

                    showAlert("The name of the task is required", "error", document.querySelector(".form .field"));

                    return;
                }

                if(edit) {
                    task.name = taskName;
                    updateTask(task);
                } else {
                    addTask(taskName);
                }
            }
        });

        document.querySelector("body").appendChild(modal);
    }

    // Shows a message in the interface

    function showAlert(message, type, reference) {

        // Prevents the creation of multiple alerts

        const previousAlert = document.querySelector(".alert");
        if(previousAlert) previousAlert.remove();

        const alert = document.createElement("DIV");
        alert.classList.add("alert", type);
        alert.textContent = message;
        reference.parentElement.insertBefore(alert, reference);
    }

    // Query the server to add a new taks to the current project

    // This is how we send a request to the php controller and get a json answer that javascript can receive

    async function addTask(task) {

        // Construct the query

        const data = new FormData();
        data.append("name", task);
        data.append("projectId", obtainProject());

        try {
            const url = "https://uptaskmvc.000webhostapp.com/api/task";
            
            // This waits until the connection with the url has been made before continuing executing code

            const answer = await fetch(url, {
                method: "POST",
                body: data
            });

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const result = await answer.json();

            if(result.type === "success") {
                const modal = document.querySelector(".modal");
                setTimeout(() => {
                    modal.remove();
                }, 300);

                // Add the task object to the global of tasks

                const taskObj = {
                    id:result.id,
                    name: task,
                    status: "0",
                    projectId: result.projectId
                }

                tasks = [...tasks, taskObj];

                // Check if there is an active filter

                const activeFilter = document.querySelector('input[name="filter"]:checked').value;

                if(activeFilter) {
                    filtered = tasks.filter(task => task.status === activeFilter);
                }

                showTasks();
            }
        } catch (error) {
            console.log(error);
        }
    }

    function changeTaskStatus(task) {
        const newStatus = task.status === "1" ? "0" : "1";
        task.status = newStatus;
        updateTask(task);
    }

    async function updateTask(task) {

        // Destructuring means taking out things out of an object or array and making them their own variable

        const {status, id, name} = task;

        const data = new FormData();
        data.append("id", id);
        data.append("name", name);
        data.append("status", status);
        data.append("projectId", obtainProject());

        try {
            const url = "https://uptaskmvc.000webhostapp.com/api/task/update";

            // This waits until the connection with the url has been made before continuing executing code

            const answer = await fetch(url, {
                method: "POST",
                body: data
            });

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const result = await answer.json();

            if(result.answer.type === "success") {

                const modal = document.querySelector(".modal");

                if(modal) {
                    setTimeout(() => {
                        modal.remove();
                    }, 300);
                }

                // .map creates a temporal array that is a copy of the original, if we didn't stop it it would be identical bet we are stopping at the one that is the one we are clicking on, change it's status on the temporal array and then returning it so it's saved on the original

                tasks = tasks.map(taskMemory => {
                    if(taskMemory.id === id) {
                        taskMemory.status = status;
                        taskMemory.name = name;
                    }

                    return taskMemory;
                });

                // Check if there is an active filter

                const activeFilter = document.querySelector('input[name="filter"]:checked').value;

                if(activeFilter) {
                    filtered = tasks.filter(task => task.status === activeFilter);
                }
    
                showTasks();
            }
            
        } catch (error) {
            console.log(error);
        }
    }

    function confirmDeleteTask(task) {
        Swal.fire({
            title: 'Do you want to delete the task?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: `No`,
          }).then((result) => {
            if (result.isConfirmed) {
              deleteTask(task);
            } 
          })
    }

    async function deleteTask(task) {

        // Destructuring means taking out things out of an object or array and making them their own variable

        const {status, id, name} = task;

        const data = new FormData();
        data.append("id", id);
        data.append("name", name);
        data.append("status", status);
        data.append("projectId", obtainProject());

        try {
            const url = "https://uptaskmvc.000webhostapp.com/api/task/delete";

            // This waits until the connection with the url has been made before continuing executing code

            const answer = await fetch(url, {
                method: "POST",
                body: data
            });

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const result = await answer.json();

            if(result.result) {

                // .filter creates a temporal array that is a copy of the original, but only the ones that fulfill or not a certain condition

                // If the arrow function is done in one line it doesn't need a return, it's already assumed it has one

                tasks = tasks.filter(taskMemory => taskMemory.id !== id);

                // Check if there is an active filter

                const activeFilter = document.querySelector('input[name="filter"]:checked').value;

                if(activeFilter) {
                    filtered = tasks.filter(task => task.status === activeFilter);
                }
    
                showTasks();
            }
            
        } catch (error) {
            console.log(error);
        }
    }

    // Obtain the id of the project from the url

    // Using this we can access to the id of the project with javascript so we can search the project in the database, it returns an object

    function obtainProject() {
        const projectParams = new URLSearchParams(window.location.search);
        const project = Object.fromEntries(projectParams.entries());
        return project.id;
    }

    function cleanTasks() {
        const tasksList = document.querySelector("#tasks-list");
        
        while(tasksList.firstChild) {
            tasksList.removeChild(tasksList.firstChild);
        }
    }
})();