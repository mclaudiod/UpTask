<?php 

    require __DIR__ . "/../vendor/autoload.php";
    require "functions.php";
    require "database.php";

    // Connect to the database

    use Model\ActiveRecord;
    ActiveRecord::setDB($db);