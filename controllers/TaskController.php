<?php

    namespace Controllers;

    use Model\Project;
    use Model\Task;

    class TaskController {
        public static function index() {
            $projectId = $_GET["id"];

            if(!$projectId) header("Location: /dashboard");

            $project = Project::where("url", $projectId);

            if(!$project || $project->ownerId !== $_SESSION["id"]) header("Location: /404");

            $tasks = Task::belongsTo("projectId", $project->id);

            // This is to send a json answer, there is a request from javascript and this is how we send the answer

            echo json_encode(["tasks" => $tasks]);
        }

        public static function create() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {

                $project = Project::where("url", $_POST["projectId"]);

                if(!$project || $project->ownerId !== $_SESSION["id"]) {
                    $answer = [
                        "type" => "error"
                    ];

                    // This is to send a json answer, there is a request from javascript and this is how we send the answer

                    echo json_encode($answer);
                    return;
                }

                // All good, saving the task

                $task = new Task($_POST);
                $task->projectId = $project->id;
                $result = $task->save();
                $answer = [
                    "type" => "success",
                    "id" => $result["id"],
                    "projectId" => $project->id
                ];

                // This is to send a json answer, there is a request from javascript and this is how we send the answer
                
                echo json_encode($answer);
            }
        }

        public static function update() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                
                // Validate that the project exists

                $project = Project::where("url", $_POST["projectId"]);

                if(!$project || $project->ownerId !== $_SESSION["id"]) {
                    $answer = [
                        "type" => "error"
                    ];

                    // This is to send a json answer, there is a request from javascript and this is how we send the answer

                    echo json_encode($answer);
                    return;
                }

                $task = new Task($_POST);
                $task->projectId = $project->id;
                $result = $task->save();

                if($result) {
                    $answer = [
                        "type" => "success",
                        "id" => $task->id,
                        "projectId" => $project->id
                    ];

                    // This is to send a json answer, there is a request from javascript and this is how we send the answer
                
                    echo json_encode(["answer" => $answer]);
                }
            }
        }

        public static function delete() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {

                // Validate that the project exists

                $project = Project::where("url", $_POST["projectId"]);

                if(!$project || $project->ownerId !== $_SESSION["id"]) {
                    $answer = [
                        "type" => "error"
                    ];

                    // This is to send a json answer, there is a request from javascript and this is how we send the answer

                    echo json_encode($answer);
                    return;
                }

                $task = new Task($_POST);
                $task->projectId = $project->id;
                $result = $task->delete();

                $result = [
                    "result" => $result
                ];

                // This is to send a json answer, there is a request from javascript and this is how we send the answer
            
                echo json_encode($result);
                
            }
        }
    }