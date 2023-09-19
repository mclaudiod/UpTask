<?php 

    require_once __DIR__ . '/../includes/app.php';

    use Controllers\DashboardController;
    use Controllers\LoginController;
    use Controllers\TaskController;
    use MVC\Router;

    $router = new Router();

    // Login

    $router->get("/", [LoginController::class, "login"]);
    $router->post("/", [LoginController::class, "login"]);
    $router->get("/logout", [LoginController::class, "logout"]);

    // Create Account

    $router->get("/create-account", [LoginController::class, "create"]);
    $router->post("/create-account", [LoginController::class, "create"]);

    // Forgot password form

    $router->get("/forgot-password", [LoginController::class, "forgot"]);
    $router->post("/forgot-password", [LoginController::class, "forgot"]);

    // Set new password

    $router->get("/reset-password", [LoginController::class, "reset"]);
    $router->post("/reset-password", [LoginController::class, "reset"]);

    // Account Confirmation

    $router->get("/message", [LoginController::class, "message"]);
    $router->get("/confirmation", [LoginController::class, "confirmation"]);

    // Projects Zone

    $router->get("/dashboard", [DashboardController::class, "index"]);
    $router->get("/create-project", [DashboardController::class, "create"]);
    $router->post("/create-project", [DashboardController::class, "create"]);
    $router->get("/project", [DashboardController::class, "project"]);
    $router->get("/profile", [DashboardController::class, "profile"]);
    $router->post("/profile", [DashboardController::class, "profile"]);
    $router->get("/change-password", [DashboardController::class, "change"]);
    $router->post("/change-password", [DashboardController::class, "change"]);

    // API for the tasks

    $router->get("/api/tasks", [TaskController::class, "index"]);
    $router->post("/api/task", [TaskController::class, "create"]);
    $router->post("/api/task/update", [TaskController::class, "update"]);
    $router->post("/api/task/delete", [TaskController::class, "delete"]);

    // Verifies and validates the routes, that they exist and asigns them the functions of the Controller

    $router->verifyRoutes();