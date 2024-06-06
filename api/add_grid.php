<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if (!isset($_POST['hall'])) {
    $result = ['status' => false, 'mess' => "Не заполнены обязательные поля"];
} else {
    $hallID = (int)$_POST['hall'];
    $filmID = (int)$_POST['film'];
    $timeStart = $_POST['start_time'];
    if(canChange($hallID)) {
        $addFrid = $db->insert('seances', [
            'hall_id' => $hallID,
            'film_id' => $filmID,
            'time_start' => $timeStart,
        ]);
        if ($addFrid) {
            $result = ['status' => true];
        } else {
            $result = ['status' => false, 'mess' => print_r($addFrid->errorInfo(), true)];
        }
    } else {
        $result = ['status' => false, 'mess' => 'Для добавления сеанса приостановите продажу билетов'];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);