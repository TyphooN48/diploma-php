<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if (!isset($_POST['seanceID'])) {
    $result = ['status' => false, 'mess' => "Ошибка удаления сеанса"];
} else {
    $seanceID = (int)($_POST['seanceID']);
    $deleteSeance = $db->delete('seances', ['id' => $seanceID]);
    if ($deleteSeance) {
        $result = ['status' => true];
    } else {
        $result = ['status' => false, 'mess' => print_r($deleteSeance->errorInfo(), true)];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);