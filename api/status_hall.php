<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if(!isset($_POST['type'])) {
    $result = ['status' => false, 'mess' => "Ошибка запроса"];
} else {
    $hallID = (int)$_POST['hallID'];
    switch ($_POST['type']) {
        case 'get':
            $hallStatus = $db->selectWhere('halls', ['status'], ['id' => $hallID]);
            if($hallStatus) {
                $result = ['status' => true, 'data' => (bool)$hallStatus[0]['status']];
            } else {
                $result = ['status' => false, 'mess' => print_r($hallStatus->errorInfo(), true)];
            }
            break;
        case 'set':
            $hallStatusAdd = $db->update('halls', ['status' => (int)$_POST['status']], ['id' => $hallID]);
            if($hallStatusAdd) {
                $result = ['status' => true];
            } else {
                $result = ['status' => false, 'mess' => print_r($hallStatusAdd->errorInfo(), true)];
            }

    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);