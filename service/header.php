<?php
session_start();

spl_autoload_register(
    function ($class_name) {
        include $_SERVER['DOCUMENT_ROOT'] . "/classes/" . $class_name . '.php';
    }
);

$db = new Database();
$user = new User($db);
$serverPathRoot = '/var/www/html';

function canChange($hallID) {
    global $db;
    $hallStatus = $db->selectWhere('halls', ['status'], ['id' => $hallID]);
    if($hallStatus)
        return !((bool)$hallStatus[0]['status']);
    else
        return false;
}