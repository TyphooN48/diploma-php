<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];
if (!isset($_POST['name']) && !isset($_POST['duration'])) {
    $result = ['status' => false, 'mess' => "Не заполнены обязательные поля"];
} else {
    $filmName = htmlspecialchars($_POST['name']);
    $filmDuration = htmlspecialchars($_POST['duration']);
    $filmNDescription = htmlspecialchars($_POST['description']);
    $filmNCountry = htmlspecialchars($_POST['country']);
    $filmPoster = $_FILES['poster'];

    $uploaddir = $serverPathRoot . '/uploads/';
    $fileName = explode(".", basename($filmPoster['name']));
    $uploadfile = $uploaddir . time() . '.' . end($fileName);

    if (move_uploaded_file($filmPoster['tmp_name'], $uploadfile)) {
        $addFilm = $db->insert('films', [
            'name' => $filmName,
            'duration' => $filmDuration,
            'description' => $filmNDescription,
            'country' => $filmNCountry,
            'poster' => substr($uploadfile, strlen($serverPathRoot))
        ]);

        if ($addFilm) {
            $result = ['status' => true];
        } else {
            $result = ['status' => false, 'mess' => print_r($addFilm->errorInfo(), true)];
        }
    } else {
        $result = ['status' => false, 'mess' => "Ошибка загрузки постера. Проверьте конфигурацию сервера."];
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);