<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$registerSuccess = $user->register('test@ya.ru', 'test');
if ($registerSuccess) {
    echo "Регистрация прошла успешно!";
} else {
    echo "Ошибка при регистрации.";
}