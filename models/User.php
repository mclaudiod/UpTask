<?php

    namespace Model;

    use Model\ActiveRecord;

    class User extends ActiveRecord {
        protected static $table = "users";
        protected static $dbColumns = ["id", "name", "email", "password", "token", "confirmed"];

        public $id;
        public $name;
        public $email;
        public $password;
        public $rpassword;
        public $cpassword;
        public $npassword;
        public $token;
        public $confirmed;

        public function __construct($args = []) {
            $this->id = $args["id"] ?? null;
            $this->name = $args["name"] ?? "";
            $this->email = $args["email"] ?? "";
            $this->password = $args["password"] ?? "";
            $this->rpassword = $args["rpassword"] ?? "";
            $this->cpassword = $args["cpassword"] ?? "";
            $this->npassword = $args["npassword"] ?? "";
            $this->token = $args["token"] ?? "";
            $this->confirmed = $args["confirmed"] ?? 0;
        }

        // Log In Validation

        public function validateLogIn() {
            if(!$this->email) {
                self::$alerts["error"][] = "Your email is required";
            }

            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$alerts["error"][] = "Invalid Email";
            }

            if(!$this->password) {
                self::$alerts["error"][] = "Your password is required";
            }

            return self::$alerts;
        }

        // New Account Validation

        public function validateNewAccount() {
            if(!$this->name) {
                self::$alerts["error"][] = "Your name is required";
            }

            if(!$this->email) {
                self::$alerts["error"][] = "Your email is required";
            }

            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$alerts["error"][] = "Invalid Email";
            }

            if(!$this->password) {
                self::$alerts["error"][] = "Your password is required";
            }

            if(strlen($this->password) < 6) {
                self::$alerts["error"][] = "Your password must have at least 6 characters";
            }

            if($this->password !== $this->rpassword) {
                self::$alerts["error"][] = "Your passwords are different";
            }

            return self::$alerts;
        }

        // Validates an email

        public function validateEmail() {
            if(!$this->email) {
                self::$alerts["error"][] = "Your email is required";
            }

            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$alerts["error"][] = "Invalid Email";
            }

            return self::$alerts;
        }

        // Validates a password

        public function validatePassword() {
            if(!$this->password) {
                self::$alerts["error"][] = "Your password is required";
            }

            if(strlen($this->password) < 6) {
                self::$alerts["error"][] = "Your password must have at least 6 characters";
            }

            if($this->password !== $this->rpassword) {
                self::$alerts["error"][] = "Your passwords are different";
            }

            return self::$alerts;
        }

        // Validates the profile

        public function validateProfile() {
            if(!$this->name) {
                self::$alerts["error"][] = "Your name is required";
            }

            if(!$this->email) {
                self::$alerts["error"][] = "Your email is required";
            }

            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$alerts["error"][] = "Invalid Email";
            }

            return self::$alerts;
        }

        // Validates the change of password

        public function newPassword() : array {
            if(!$this->cpassword) {
                self::$alerts["error"][] = "Your current password is required";
            }

            if(!$this->npassword) {
                self::$alerts["error"][] = "Your new password is required";
            }

            if(strlen($this->npassword) < 6) {
                self::$alerts["error"][] = "Your new password must have at least 6 characters";
            }

            if($this->npassword !== $this->rpassword) {
                self::$alerts["error"][] = "Your passwords are different";
            }

            return self::$alerts;
        }

        // Checks the password

        public function checkPassword() : bool {
            return password_verify($this->cpassword, $this->password);
        }

        // Hashes the password

        public function hashPassword() : void {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

        // Generate a token

        public function createToken() : void {
            $this->token = uniqid();
        }

    }