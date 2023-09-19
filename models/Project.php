<?php

    namespace Model;

    use Model\ActiveRecord;

    class Project extends ActiveRecord {
        protected static $table = "projects";
        protected static $dbColumns = ["id", "project", "url", "ownerId"];

        public $id;
        public $project;
        public $url;
        public $ownerId;

        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->project = $args["project"] ?? "";
            $this->url = $args["url"] ?? "";
            $this->ownerId = $args["ownerId"] ?? "";
        }

        // Project Validation

        public function validateProject() {
            if(!$this->project) {
                self::$alerts["error"][] = "The name of your project is required";
            }

            return self::$alerts;
        }
    }