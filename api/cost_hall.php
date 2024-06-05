<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if(!isset($_POST['type'])) {
    $result = ['status' => false, 'mess' => "Ошибка запроса"];
} else {
    switch ($_POST['type']) {
        case 'get':
            $hallID = (int)$_POST['hallID'];
            $hallCost = $db->selectWhere('halls', ['cost'], ['id' => $hallID]);
            break;
    }
    if($hallCost) {
        $result = ['status' => true, 'data' => json_decode($hallCost[0]['cost'], true)];
    } else {
        $result = ['status' => false, 'mess' => print_r($hallCost->errorInfo(), true)];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);