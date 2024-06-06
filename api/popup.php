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
                                <span class="popup__dismiss"><img src="/admin/i/close.png" alt="Закрыть"></span>
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
            if (!$hall) {
                $result = ['status' => false, 'data' => print_r($hall, true)];
            } else {
                $result = ['status' => true,
                    'data' => '<div class="popup active">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление зала
                                    <span class="popup__dismiss"><img src="/admin/i/close.png" alt="Закрыть"></span>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form method="post" accept-charset="utf-8" id="deleteHall">
                                    <p class="conf-step__paragraph">Вы действительно хотите удалить зал <span>' . htmlspecialchars($hall[0]['name']) . '</span>?</p>
                                    <div class="conf-step__buttons text-center">
                                        <p class="text-center" style="color: red; display: none" id="errText"></p>
                                        <input type="hidden" name="hallID" value="' . $hall[0]['id'] . '">
                                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>'];
            }
            break;
        case 'addFilm':
            $result = ['status' => true,
                'data' => '<div class="popup active">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Добавление фильма
                                    <span class="popup__dismiss"><img src="/admin/i/close.png" alt="Закрыть"></a>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form method="post" accept-charset="utf-8" id="addFilm">
                                    <div class="popup__container">
                                        <div class="popup__form">
                                            <label class="conf-step__label conf-step__label-fullsize" for="name">
                                                Название фильма
                                                <input class="conf-step__input" type="text" name="name" if="name" placeholder="Атака клонированных клонов" required>
                                            </label>
                                                <label class="conf-step__label conf-step__label-fullsize" for="duration">
                                                Продолжительность фильма (мин.)
                                                <input class="conf-step__input" type="number" min="0" name="duration" id="duration" required>
                                            </label>
                                            <label class="conf-step__label conf-step__label-fullsize" for="description">
                                                Описание фильма
                                                <textarea class="conf-step__input" type="text" name="description" id="description" required></textarea>
                                            </label>
                                            <label class="conf-step__label conf-step__label-fullsize" for="country">
                                                Страна
                                                <input class="conf-step__input" type="text" name="country" id="country" required>
                                            </label>
                                            <label class="conf-step__label conf-step__label-fullsize" for="poster">
                                                Постер
                                                <input class="conf-step__input" type="file" name="poster" id="poster" accept="image/jpeg,image/png" required>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="text-center" style="color: red; display: none" id="errTextFilm"></p>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent" data-event="film_add">
                                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>'];
            break;
        case 'addFilmInGid':
            $selectFilm = $db->selectWhere('films', ['id', 'name'], ['id' => $_POST['filmID']]);
            $allFilms = $db->selectWhere('films', ['id', 'name'], []);
            $filmOpt = '';
            foreach ($allFilms as $film) {
                $filmOpt .= '<option value="' . $film['id'] . '"' . (($film['id'] == $_POST['filmID']) ? 'selected' : '') . '>' . $film['name'] . '</option>';
            }
            $allHalls = $db->selectWhere('halls', ['id', 'name'], []);
            $hallOpt = '';
            foreach ($allHalls as $hall) {
                $hallOpt .= '<option value="' . $hall['id'] . '">' . $hall['name'] . '</option>';
            }

            if (!$selectFilm) {
                $result = ['status' => false, 'data' => print_r($selectFilm, true)];
            } else {
                $result = ['status' => true,
                    'data' => '<div class="popup active">
                        <div class="popup__container">
                            <div class="popup__content">
                                <div class="popup__header">
                                    <h2 class="popup__title">
                                        Добавление сеанса
                                        <span class="popup__dismiss"><img src="/admin/i/close.png" alt="Закрыть"></span>
                                    </h2>
                                </div>
                            <div class="popup__wrapper">
                                <form method="post" accept-charset="utf-8" id="setFilmGrid">
                                    <label class="conf-step__label conf-step__label-fullsize" for="hall">
                                        Название зала
                                        <select class="conf-step__input" name="hall" required>' . $hallOpt . '</select>
                                    </label>
                                    <label class="conf-step__label conf-step__label-fullsize" for="film">
                                        Название фильма
                                        <select class="conf-step__input" name="film" required>' . $filmOpt . '</select>
                                    </label>
                                    <label class="conf-step__label conf-step__label-fullsize" for="start_time">
                                        Время начала
                                        <input class="conf-step__input" type="time" value="00:00" name="start_time" required>
                                    </label>
                                    <p class="text-center" style="color: red; display: none" id="errTextGrid"></p>
                                    <div class="conf-step__buttons text-center">
                                        <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent" data-event="seance_add">
                                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>'];
            }
            break;
        case 'deleteFilm':
            $selectFilm = $db->selectWhere('films', ['id', 'name'], ['id' => $_POST['filmID']]);
            if (!$selectFilm) {
                $result = ['status' => false, 'data' => print_r($selectFilm, true)];
            } else {
                $result = ['status' => true,
                    'data' => '<div class="popup active">
                    <div class="popup__container">
                        <div class="popup__content">
                            <div class="popup__header">
                                <h2 class="popup__title">
                                    Удаление фильма
                                    <span class="popup__dismiss"><img src="/admin/i/close.png" alt="Закрыть"></span>
                                </h2>
                            </div>
                            <div class="popup__wrapper">
                                <form method="post" accept-charset="utf-8" id="daleteFilm">
                                    <p class="conf-step__paragraph">Вы действительно хотите удалить фильм "' . htmlspecialchars($selectFilm[0]['name']) . '"?</p>
                                    <div class="conf-step__buttons text-center">
                                        <p class="text-center" style="color: red; display: none" id="errTextDelFilm"></p>
                                        <input type="hidden" name="filmID" value="' . $selectFilm[0]['id'] . '">
                                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>'];
            }
            break;
        case 'deleteSeance':
            $selectSeance = $db->selectWhere('seances', ['id', 'film_id'], ['id' => $_POST['seanceID']]);
            if (!$selectSeance) {
                $result = ['status' => false, 'data' => print_r($selectSeance, true)];
            } else {
                $selectFilm = $db->selectWhere('films', ['name'], ['id' => $selectSeance[0]['film_id']]);
                if (!$selectFilm) {
                    $result = ['status' => false, 'data' => print_r($selectFilm, true)];
                } else {
                    $result = ['status' => true,
                        'data' => '<div class="popup active">
                        <div class="popup__container">
                            <div class="popup__content">
                                <div class="popup__header">
                                    <h2 class="popup__title">
                                        Снятие с сеанса
                                        <span class="popup__dismiss"><img src="/admin/i/close.png" alt="Закрыть"></span>
                                    </h2>
                                </div>
                                <div class="popup__wrapper">
                                    <form method="post" accept-charset="utf-8" id="deleteSeance">
                                        <p class="conf-step__paragraph">Вы действительно хотите снять с сеанса фильм "' . htmlspecialchars($selectFilm[0]['name']) . '"?</p>
                                        <div class="conf-step__buttons text-center">
                                            <p class="text-center" style="color: red; display: none" id="errTextDelSeance"></p>
                                            <input type="hidden" name="seanceID" value="' . $selectSeance[0]['id'] . '">
                                            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                                            <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>'];
                }
            }
            break;
        default:
            $result = ['status' => false, 'data' => "Ошибка в типе модального окна"];
            break;
    }
}
print json_encode($result, JSON_UNESCAPED_UNICODE);