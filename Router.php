<?php

    namespace MVC;

    class Router {
        public array $getRoutes = [];
        public array $postRoutes = [];

        public function get($url, $fn) {
            $this->getRoutes[$url] = $fn;
        }

        public function post($url, $fn) {
            $this->postRoutes[$url] = $fn;
        }

        public function verifyRoutes() {

            session_start();

            $currentUrl = isset($_SERVER['PATH_INFO']) ? str_replace("/public_html", "", $_SERVER['PATH_INFO']) : '/';
            $method = $_SERVER['REQUEST_METHOD'];

            if ($method === 'GET') {
                $fn = $this->getRoutes[$currentUrl] ?? null;
            } else {
                $fn = $this->postRoutes[$currentUrl] ?? null;
            }


            if ( $fn ) {

                // Call user fn calls a function that we don't know what's going to be

                call_user_func($fn, $this); // This is to send arguments
            } else {
                echo("Page Not Found");
            }
        }

        public function render($view, $data = []) {

            // Read what we are sending to the view

            foreach ($data as $key => $value) {
                $$key = $value;  // Double dollar sign means: variable variable, our variable continues being the original, but asigning it to another doesn't overwrite it, mantains its value, this way the name of the variable is asigned dinamically
            }

            ob_start(); // Saving it on memory for a moment...

            // Then we include the view en the layout

            include_once __DIR__ . "/views/$view.php";
            $content = ob_get_clean(); // Cleans the memory
            include_once __DIR__ . '/views/layout.php';
        }
    }