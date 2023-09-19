<?php

    namespace Model;

    use Model\ActiveRecord;

    class Task extends ActiveRecord {
        protected static $table = "tasks";
        protected static $dbColumns = ["id", "name", "status", "projectId"];

        public $id;
        public $name;
        public $status;
        public $projectId;

        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
            $this->status = $args["status"] ?? 0;
            $this->projectId = $args["projectId"] ?? "";
        }

        // Project Validation

        // public function validateProject() {
        //     if(!$this->project) {
        //         self::$alerts["error"][] = "The name of your project is required";
        //     }

        //     return self::$alerts;
        // }
    }