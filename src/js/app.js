const mobileMenuBtn = document.querySelector("#mobile-menu");
const closeMenuBtn = document.querySelector("#close-menu");
const sidebar = document.querySelector(".sidebar");

if(mobileMenuBtn) {
    mobileMenuBtn.addEventListener("click", function() {
        sidebar.classList.add("show");
    });
}

if(closeMenuBtn) {
    closeMenuBtn.addEventListener("click", function() {
        sidebar.classList.add("hide");

        setTimeout(() => {
            sidebar.classList.remove("show");
            sidebar.classList.remove("hide");
        }, 300);
    });
}

// Deletes the class of show, in tablet size or bigger

window.addEventListener("resize", function() {
    const screenWidth = document.body.clientWidth;

    if(screenWidth >= 768) {
        sidebar.classList.remove("show");
    }
})