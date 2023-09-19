<?php

    namespace Controllers;

    use Model\Project;
    use Model\User;
    use MVC\Router;

    class DashboardController {
        public static function index(Router $router) {
            isAuth();

            $projects = Project::belongsTo("ownerId", $_SESSION["id"]);

            $router->render("dashboard/index", [
                "title" => "Projects",
                "projects" => $projects
            ]);
        }

        public static function create(Router $router) {
            isAuth();
            $alerts = [];

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $project = new Project($_POST);

                // Validation

                $alerts = $project->validateProject();

                if(empty($alerts)) {

                    // Generate a unique url

                    $project->url = md5(uniqid());

                    // Save the creator of the project

                    $project->ownerId = $_SESSION["id"];

                    // Save the project

                    $project->save();

                    header("Location: /project?id=" . $project->url);
                }
            }

            $alerts = Project::getAlerts();

            $router->render("dashboard/create-project", [
                "title" => "Create Project",
                "alerts" => $alerts
            ]);
        }

        public static function project(Router $router) {
            isAuth();
            $token = $_GET["id"];
            if(!$token) header("Location: /dashboard");

            // Check that the visiting person is the creator

            $project = Project::where("url", $token);

            if($project->ownerId !== $_SESSION["id"]) {
                header("Location: /dashboard");
            }

            $router->render("dashboard/project", [
                "title" => $project->project
            ]);
        }

        public static function profile(Router $router) {
            isAuth();
            $alerts = [];
            $user= User::find($_SESSION["id"]);

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $user->synchronize($_POST);
                $alerts = $user->validateProfile();

                if(empty($alerts)) {
                    $userExists = User::where("email", $user->email);

                    if($userExists && $userExists->id !== $user->id) {
                        User::setAlert("error", "Your email is already registered");
                    } else {
                        $user->save();

                        User::setAlert("success", "Changes saved successfully");

                        $_SESSION["name"] = $user->name;
                        $_SESSION["email"] = $user->email;
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("dashboard/profile", [
                "title" => "Profile",
                "alerts" => $alerts,
                "user" => $user
            ]);
        }

        public static function change(Router $router) {
            isAuth();
            $alerts = [];
            $user= User::find($_SESSION["id"]);

            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $user->synchronize($_POST);
                $alerts = $user->newPassword();

                if(empty($alerts)) {
                    $result = $user->checkPassword();

                    if($result) {
                        $user->password = $user->npassword;

                        // Delete unnecessary properties

                        unset($user->cpassword);
                        unset($user->npassword);
                        unset($user->rpassword);

                        // Hash the new password

                        $user->hashPassword();

                        // Saves the new password

                        $result = $user->save();

                        if($result) {
                            User::setAlert("success", "Password changed successfully");
                        }

                    } else {
                        User::setAlert("error", "Incorrect Password");
                    }
                }
            }

            $alerts = User::getAlerts();

            $router->render("dashboard/change-password", [
                "title" => "Change Password",
                "alerts" => $alerts,
                "user" => $user
            ]);
        }
    }