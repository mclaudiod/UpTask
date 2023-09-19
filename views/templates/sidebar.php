<aside class="sidebar">
    <div class="sidebar-container">
        <h2>UpTask</h2>
        <img src="./build/img/cerrar.svg" alt="close menu image" id="close-menu">
    </div>

    <nav class="sidebar-nav">
        <a class="<?php echo ($title === "Projects") ? "active" : ""; ?>" href="/dashboard">Projects</a>
        <a class="<?php echo ($title === "Create Project") ? "active" : ""; ?>" href="/create-project">Create Project</a>
        <a class="<?php echo ($title === "Profile") ? "active" : ""; ?>" href="/profile">Profile</a>
    </nav>

    <div class="log-out-mobile">
        <a href="/logout" class="log-out">Log Out</a>
    </div>
</aside>