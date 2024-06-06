<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if (!isset($_POST['seanceID'])) {
    $result = ['status' => false, 'mess' => "Ошибка удаления сеанса"];
} else {
    $seanceID = (int)($_POST['seanceID']);
    $hallID = $db->selectWhere('seances', ['hall_id'], ['id' => $seanceID])[0]['hall_id'];
    if(canChange($hallID)) {
        $deleteSeance = $db->delete('seances', ['id' => $seanceID]);
        if ($deleteSeance) {
            $result = ['status' => true];
        } else {
            $result = ['status' => false, 'mess' => print_r($deleteSeance->errorInfo(), true)];
        }
    } else {
        $result = ['status' => false, 'mess' => 'Для удаления сеанса приостановите продажу билетов'];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);