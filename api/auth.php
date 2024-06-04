<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if(!isset($_POST['email']) || !isset($_POST['password'])) {
    $result = ['status' => false, 'mess' => "Не заполнены обязательные поля"];
} else {

    $login = htmlspecialchars($_POST['email']);
    $pass = $_POST['password'];

    $loginSuccess = $user->login($login, $pass);
    if ($loginSuccess) {
        $result = ['status' => true, 'mess' => ""];
    } else {
        $result = ['status' => false, 'mess' => "Введен неверный логин или пароль"];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);
