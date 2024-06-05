<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if(!isset($_POST['name'])) {
    $result = ['status' => false, 'mess' => "Не заполнены обязательные поля"];
} else {
    $hallName = htmlspecialchars($_POST['name']);
    $addHall = $db->insert('halls', ['name' => $hallName]);

    if($addHall) {
        $result = ['status' => true];
    } else {
        $result = ['status' => false, 'mess' => print_r($addHall->errorInfo(), true)];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);