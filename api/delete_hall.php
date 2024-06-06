<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if(!isset($_POST['hallID'])) {
    $result = ['status' => false, 'mess' => "Ошибка удаления зала"];
} else {
    $hallID = (int)($_POST['hallID']);
    $deleteSeance = $db->delete('seances', ['hall_id' => $hallID]);
    if($deleteSeance) {
        $deleteHall = $db->delete('halls', ['id' => $hallID]);
        if($deleteHall) {
            $result = ['status' => true];
        } else {
            $result = ['status' => false, 'mess' => print_r($deleteHall->errorInfo(), true)];
        }
    } else {
        $result = ['status' => false, 'mess' => print_r($deleteSeance->errorInfo(), true)];
    }



}

print json_encode($result, JSON_UNESCAPED_UNICODE);