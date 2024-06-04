<?php
$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];

if (!$user->isLoggedIn()) {
    header('Location: /admin/login.php');
}