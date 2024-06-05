<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';

$result = [];

if (!isset($_POST['type'])) {
    $result = ['status' => false, 'data' => "Ошибка, нет типа модального окна"];
} else {
    $type = $_POST['type'];
    switch ($type) {
        case 'addHall':
            $result = ['status' => true,
                'data' => '<div class="popup active">
                <div class="popup__container">
                    <div class="popup__content">
                        <div class="popup__header">
                            <h2 class="popup__title">
                                Добавление зала
                                <a class="popup__dismiss" href="#"><img src="/admin/i/close.png" alt="Закрыть"></a>
                            </h2>
                        </div>
                        <div class="popup__wrapper">
                            <form method="post" accept-charset="utf-8" id="addHall">
                                <label class="conf-step__label conf-step__label-fullsize" for="name">
                                    Название зала
                                    <input class="conf-step__input" type="text" placeholder="Большой зал" name="name" required>
                                </label>
                                <p class="text-center" style="color: red; display: none" id="errText"></p>
                                <div class="conf-step__buttons text-center">
                                    <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent" data-event="hall_add">
                                    <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>'];
            break;
        case 'deleteHall':
            $hall = $db->selectWhere('halls', ['id', 'name'], ['id' => $_POST['hallID']]);
            if(!$hall) {
                $result = ['status' => false, 'data' => print_r($hall, true)];
            } else {
                $result = ['status' => true,
                    'data' => '<div class="popup active">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление зала
                                    <a class="popup__dismiss" href="#"><img src="/admin/i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form method="post" accept-charset="utf-8" id="deleteHall">
                                    <p class="conf-step__paragraph">Вы действительно хотите удалить зал <span>' . htmlspecialchars($hall[0]['name']) . '</span>?</p>
                                    <div class="conf-step__buttons text-center">
                                        <p class="text-center" style="color: red; display: none" id="errText"></p>
                                        <input type="hidden" name="hallID" value="' . $hall[0]['id'] . '">
                                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent" data-event="hall_del">
                                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>'];
            }
            break;
        default:
            $result = ['status' => false, 'data' => "Ошибка в типе модального окна"];
            break;
    }
}

print json_encode($result, JSON_UNESCAPED_UNICODE);