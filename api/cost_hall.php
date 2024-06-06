<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if(!isset($_POST['type'])) {
    $result = ['status' => false, 'mess' => "Ошибка запроса"];
} else {
    $hallID = (int)$_POST['hallID'];
    switch ($_POST['type']) {
        case 'get':
            $hallCost = $db->selectWhere('halls', ['cost'], ['id' => $hallID]);
            if($hallCost) {
                $result = ['status' => true, 'data' => json_decode($hallCost[0]['cost'], true)];
            } else {
                $result = ['status' => false, 'mess' => print_r($hallCost->errorInfo(), true)];
            }
            break;
        case 'set':
            $data = ['standart' => (int)$_POST['standart'], 'vip' => (int)$_POST['vip']];
            if(canChange($hallID)) {
                $hallCostAdd = $db->update('halls', ['cost' => json_encode($data, JSON_UNESCAPED_UNICODE)], ['id' => $hallID]);
                if ($hallCostAdd) {
                    $result = ['status' => true];
                } else {
                    $result = ['status' => false, 'mess' => print_r($hallCostAdd->errorInfo(), true)];
                }
            } else {
                $result = ['status' => false, 'mess' => 'Для изменения стоимости приостановите продажу билетов'];
            }

    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);