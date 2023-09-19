<?php

    function debug($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;
    };

    // Escape/Sanitize HTML

    function esc($html) : string {
        $esc = htmlspecialchars($html);
        return $esc;
    };

    // Function that checks if the user is authenticated

    function isAuth() : void {
        if(!isset($_SESSION["login"])) {
            header("Location: /");
        };
    };