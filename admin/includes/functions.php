<?php
// Attempt to load undefined class
function classAutoLoader($class) {
    $class = strtolower($class);

    $thePath = "includes/{$class}.php";

    if(is_file($thePath) && !class_exists($class)) {
        include $thePath;
    } else {
        die("This file names {$class}.php was not found!");
    }
}

// Controlling access to Admin
function redirect($location) {
    // Send a raw HTTP header
    header("Location: {$location}");
}

// Register given function as __autoload() implementation
spl_autoload_register('classAutoLoader');
?>