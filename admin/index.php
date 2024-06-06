<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/service/redirect.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ИдёмВКино</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">
</head>

<body>

<header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторская</span>
</header>

<main class="conf-steps">
    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Управление залами</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Доступные залы:</p>
            <ul class="conf-step__list">
                <? $allHalls = $db->selectWhere('halls', ['id', 'name'], []);
                foreach ($allHalls as $hall): ?>
                    <li>
                        <?= $hall['name'] ?>
                        <button class="conf-step__button conf-step__button-trash delete_hall"
                                data-idhall="<?= $hall['id'] ?>"></button>
                    </li>
                <? endforeach; ?>
            </ul>
            <button class="conf-step__button conf-step__button-accent" id="addHallBtn">Создать зал</button>
        </div>
    </section>

    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Конфигурация залов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
            <ul class="conf-step__selectors-box">
                <?foreach ($allHalls as $hall): ?>
                    <li>
                        <input type="radio" class="conf-step__radio" name="chairs-hall" value="<?=$hall['id']?>"><span
                                class="conf-step__selector"><?=$hall['name']?></span>
                    </li>
                <?endforeach;?>
            </ul>
            <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">
                    Рядов, шт<input type="number" min="1" max="20" class="conf-step__input" placeholder="2" id="hallRows" disabled>
                </label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">
                    Мест, шт<input type="number" min="1" max="21" class="conf-step__input" placeholder="4" id="hallRowPlaces" disabled>
                </label>
            </div>
            <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
            <div class="conf-step__legend">
                <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
            </div>

            <div class="conf-step__hall">
                <div class="conf-step__hall-wrapper" id="hallGrid"></div>
            </div>
            <p class="text-center" style="color: red; display: none" id="gridError"></p>
            <div class="conf-step__wrapper__save-status" id="gridSave"></div>
            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular" id="canselGrid">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" id="saveGrid" disabled>
            </fieldset>
        </div>
    </section>

    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Конфигурация цен</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
            <ul class="conf-step__selectors-box">
                <?foreach ($allHalls as $hall): ?>
                    <li>
                        <input type="radio" class="conf-step__radio" name="prices-hall" value="<?=$hall['id']?>"><span
                                class="conf-step__selector"><?=$hall['name']?></span>
                    </li>
                <?endforeach;?>
            </ul>

            <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" id="costStandart"></label>
                за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
            </div>
            <div class="conf-step__legend">
                <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" id="costVip"></label>
                за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
            </div>
            <div class="conf-step__wrapper__save-status" id="hallSave"></div>
            <p class="text-center" style="color: red; display: none" id="hallError"></p>
            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular" id="canselCost">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" id="saveCost" disabled>
            </fieldset>
        </div>
    </section>

    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Сетка сеансов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">
                <button class="conf-step__button conf-step__button-accent" id="addFilmBtn">Добавить фильм</button>
            </p>
            <div class="conf-step__movies">
                <? $allFilms = $db->selectWhere('films', ['id', 'name', 'duration', 'poster'], []);
                foreach ($allFilms as $film): ?>
                    <div class="conf-step__movie" data-filmid="<?= $film['id'] ?>">
                        <img class="conf-step__movie-poster" alt="poster" src="<?= $film['poster'] ?>">
                        <h3 class="conf-step__movie-title"><?= $film['name'] ?></h3>
                        <p class="conf-step__movie-duration"><?= $film['duration'] ?> минут</p>
                        <button class="conf-step__button conf-step__button-trash delete-film"
                                data-idfilm="<?= $film['id'] ?>"></button>
                </div>
                <? endforeach; ?>
            </div>

            <div class="conf-step__seances">
                <? foreach ($allHalls as $hall): ?>
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title"><?= $hall['name'] ?></h3>
                        <div class="conf-step__seances-timeline">
                            <? $hallGrid = $db->selectWhere('seances', ['id', 'film_id', 'time_start'], ['hall_id' => $hall['id']]);
                            foreach ($hallGrid as $grid):
                                $filmInfo = $db->selectWhere('films', ['id', 'name', 'duration'], ['id' => $grid['film_id']])[0];
                                $posStart = ((int)explode(':', $grid['time_start'])[0] * 60 + (int)explode(':', $grid['time_start'])[1]) / 2;
                                $posEnd = $posStart + (int)$filmInfo['duration'] / 2;
                                ?>
                                <div class="conf-step__seances-movie" data-filmid="<?=$filmInfo['id']?>"
                                     style="width: <?= $posEnd - $posStart ?>px; left: <?= $posStart ?>px;">
                                    <p class="conf-step__seances-movie-title"><?= $filmInfo['name'] ?></p>
                                    <p class="conf-step__seances-movie-start"><?= $grid['time_start'] ?></p>
                                    <button class="conf-step__button conf-step__button-trash delete-seance"
                                            data-idseance="<?= $grid['id'] ?>"></button>
                                </div>
                            <? endforeach; ?>
                            <? /*<div class="conf-step__seances-movie"
                                 style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">12:00</p>
                            </div>
                            <div class="conf-step__seances-movie"
                                 style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных
                                    клонов</p>
                                <p class="conf-step__seances-movie-start">14:00</p>
                            </div>*/ ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>

            <? /*<fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>*/ ?>
        </div>
    </section>

    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Открыть продажи</h2>
        </header>
        <div class="conf-step__wrapper text-center">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
            <ul class="conf-step__selectors-box">
                <?foreach ($allHalls as $hall): ?>
                    <li>
                        <input type="radio" class="conf-step__radio" name="start-hall" value="<?=$hall['id']?>"><span
                                class="conf-step__selector"><?=$hall['name']?></span>
                    </li>
                <?endforeach;?>
            </ul>
            <p class="text-center" style="color: red; display: none" id="errStatusHall"></p>
            <div id="hallStatusDiv"></div>
            </div>
    </section>
</main>
<script src="js/accordeon.js"></script>
<script src="js/popup.js"></script>
<script src="js/hall.js"></script>
<script src="js/hallConfigure.js"></script>
<script src="js/seatsCost.js"></script>
<script src="js/film.js"></script>
</body>
</html>
