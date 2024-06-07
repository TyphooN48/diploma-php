<?php
session_start();
date_default_timezone_set('Europe/Moscow');

spl_autoload_register(
    function ($class_name) {
        include $_SERVER['DOCUMENT_ROOT'] . "/classes/" . $class_name . '.php';
    }
);

$db = new Database();
$user = new User($db);

function canChange($hallID) {
    global $db;
    $hallStatus = $db->selectWhere('halls', ['status'], ['id' => $hallID]);
    if($hallStatus)
        return !((bool)$hallStatus[0]['status']);
    else
        return false;
}

function cmp($a, $b) {
    return strnatcmp($a["time_start"], $b["time_start"]);
}