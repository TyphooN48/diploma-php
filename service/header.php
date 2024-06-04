<?php
session_start();

spl_autoload_register(
    function ($class_name) {
        include $_SERVER['DOCUMENT_ROOT'] . "/classes/" . $class_name . '.php';
    }
);

$db = new Database();
$user = new User($db);