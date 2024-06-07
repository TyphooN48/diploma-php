<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if (!isset($_POST['type'])) {
    $result = ['status' => false, 'mess' => "Ошибка запроса"];
} else {
    $hallID = (int)$_POST['hallID'];
    switch ($_POST['type']) {
        case 'get':
            $hallGrid = $db->selectWhere('halls', ['grid'], ['id' => $hallID]);
            if ($hallGrid) {
                $result = ['status' => true, 'data' => json_decode($hallGrid[0]['grid'], true)];
            } else {
                $result = ['status' => false, 'mess' => print_r($hallGrid->errorInfo(), true)];
            }
            break;
        case 'set':
            $data = [
                'rows' => (int)$_POST['rows'],
                'places' => (int)$_POST['rowPlaces'],
                'grid' => array_map('intval', explode(',', $_POST['grid']))
            ];
            if(canChange($hallID)) {
                $deleteTickets = $db->delete('tickets', ['hall_id' => $hallID]);
                if ($deleteTickets) {
                    $hallGridAdd = $db->update('halls', ['grid' => json_encode($data, JSON_UNESCAPED_UNICODE)], ['id' => $hallID]);
                    if ($hallGridAdd) {
                        $result = ['status' => true];
                    } else {
                        $result = ['status' => false, 'mess' => print_r($hallGridAdd->errorInfo(), true)];
                    }
                } else {
                    $result = ['status' => false, 'mess' => print_r($deleteTickets->errorInfo(), true)];
                }
            } else {
                $result = ['status' => false, 'mess' => 'Для изменения конфигурации зала приостановите продажу билетов'];
            }
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);