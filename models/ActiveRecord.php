<?php

    namespace Model;

    class ActiveRecord {

        // Database

        protected static $db;
        protected static $table = '';
        protected static $dbColumns = [];

        public $id;

        // Alerts and Messages

        protected static $alerts = [];

        // Define the connection to the Database

        public static function setDB($database) {
            self::$db = $database;
        }

        public static function setAlert($type, $message) {
            static::$alerts[$type][] = $message;
        }

        // Validation

        public static function getAlerts() {
            return static::$alerts;
        }

        public function validate() {
            static::$alerts = [];
            return static::$alerts;
        }

        // Registries - CRUD

        public function save() {
            $result = '';
            if(!is_null($this->id)) {

                // Update

                $result = $this->update();
            } else {

                // Create

                $result = $this->create();
            }
            return $result;
        }

        // Lists all the registries

        public static function all() {
            $query = "SELECT * FROM " . static::$table;
            $result = self::querySQL($query);
            return $result;
        }

        // Search a registry for it's id

        public static function find($id) {
            $query = "SELECT * FROM " . static::$table . " WHERE id = {$id}";
            $result = self::querySQL($query);
            return array_shift($result);
        }

        // Obtain determined number of registries

        public static function get($quantity) {
            $query = "SELECT * FROM " . static::$table . " LIMIT " . $quantity;
            $result = self::querySQL($query);
            return $result;
        }

        // Search a registry for it's column

        public static function where($column, $value) {
            $query = "SELECT * FROM " . static::$table . " WHERE {$column} = '{$value}'";
            $result = self::querySQL($query);
            return array_shift($result);
        }

        // Search all registries for it's column

        public static function belongsTo($column, $value) {
            $query = "SELECT * FROM " . static::$table . " WHERE {$column} = '{$value}'";
            $result = self::querySQL($query);
            return $result;
        }

        // Plain query of SQL (Use when the methods of the model are not enough)

        public static function SQL($query) {
            $result = self::querySQL($query);
            return $result;
        }

        // Create a new registry

        public function create() {

            // Sanitize the data

            $atributes = $this->sanitizeAtributes();

            // Insert into the database
            
            // Join makes an string out of an array
            
            $query = "INSERT INTO " . static::$table . " (";
            $query .= join(", ", array_keys($atributes));
            $query .= ") VALUES ('";
            $query .= join("', '", array_values($atributes));
            $query .= "')";

            // return json_encode(["query" => $query]);
            
            $result = self::$db->query($query);
            return [
            'result' =>  $result,
            'id' => self::$db->insert_id
            ];
        }

        // Update a registry

        public function update() {

            // Sanitize the data

            $atributes = $this->sanitizeAtributes();

            $values = [];

            foreach($atributes as $key => $value) {
                $values[] = "{$key}='{$value}'";
            }

            // Insert into the database

            $query = "UPDATE " . static::$table . " SET ";
            $query .= join(", ", $values);
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
            $query .= " LIMIT 1";

            $result = self::$db->query($query);
            return $result;
        }

        // Delete a registry

        public function delete() {
            $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $result = self::$db->query($query);
            return $result;
        }

        // Query SQL to create an object in Memory

        public static function querySQL($query) {

            // Query the database

            $result = self::$db->query($query);

            // Iterate the results

            $array = [];

            while($registry = $result->fetch_assoc()) {
                $array[] = static::createObject($registry);
            }

            // Liberate the memory

            $result->free();

            // Return the results

            return $array;
        }

        // Created the object in memory which is the same as the in the DB

        protected static function createObject($registry) {
            $object = new static;

            foreach($registry as $key => $value) {
                if(property_exists($object, $key)) {
                    $object->$key = $value;
                }
            }
            return $object;
        }

        // Identificate and link the atributes of the database

        public function atributes() {
            $atributes = [];
            foreach(static::$dbColumns as $column) {
                if($column === "id") continue;
                $atributes[$column] = $this->$column;
            }
            return $atributes;
        }

        // Sanitize the data before saving them in the DB

        public function sanitizeAtributes() {
            $atributes = $this->atributes();
            $sanitized = [];

            // Key is for the name of the variable and the value is for what is inside of it

            foreach($atributes as $key => $value) {
                $sanitized[$key] = self::$db->escape_string($value);
            }

            return $sanitized;
        }

        // Synchronize the object in memory with the changes realized by the user

        public function synchronize($args = []) {
            foreach($args as $key => $value) {
                if(property_exists($this, $key) && !is_null($value)) {
                    $this->$key = $value;
                }
            }
        }
    }