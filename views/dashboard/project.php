<?php include_once __DIR__ . "/header.php"; ?>
    <div class="sm-container">
        <div class="new-task-container">
            <button type="button" class="add-task" id="add-task">&#43; New Task</button>
        </div>

        <div id="filters" class="filters">
            <div class="filters-inputs">
                <h2>Filters:</h2>
                <div class="field">
                    <label for="all">All</label>
                    <input type="radio" id="all" name="filter" value=""
                    checked>
                </div>

                <div class="field">
                    <label for="complete">Complete</label>
                    <input type="radio" id="complete" name="filter" value="1">
                </div>

                <div class="field">
                    <label for="pending">Pending</label>
                    <input type="radio" id="pending" name="filter" value="0">
                </div>
            </div>
        </div>

        <ul id="tasks-list" class="tasks-list"></ul>
    </div>
<?php include_once __DIR__ . "/footer.php"; ?>

<?php $script .= " <script src='build/js/tasks.js'></script> <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; ?>