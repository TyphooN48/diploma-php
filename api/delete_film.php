<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if (!isset($_POST['filmID'])) {
    $result = ['status' => false, 'mess' => "Ошибка удаления фильма"];
} else {
    $filmID = (int)($_POST['filmID']);
    $poster = $db->selectWhere('films', ['poster'], ['id' => $filmID]);
    unlink($serverPathRoot . $poster[0]['poster']);
    $deleteSeance = $db->delete('seances', ['film_id' => $filmID]);
    if ($deleteSeance) {
        $deleteFilm = $db->delete('films', ['id' => $filmID]);
        if ($deleteFilm) {
            $result = ['status' => true];
        } else {
            $result = ['status' => false, 'mess' => print_r($deleteFilm->errorInfo(), true)];
        }
    } else {
        $result = ['status' => false, 'mess' => print_r($deleteSeance->errorInfo(), true)];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);