<? require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php'; ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ИдёмВКино</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">
</head>

<body>
<header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
</header>

<nav class="page-nav">
    <?php
    $first = 'page-nav__day_today page-nav__day_chosen';
    $days = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
    for ($i = 0; $i < 7; $i++):
        $day = strtotime("+$i day");
        $dayWeek = $days[date('w', $day)];
        $class = '';
        if (date('w', $day) == 0 || date('w', $day) == 6)
            $class = ' page-nav__day_weekend'; ?>
        <span class="page-nav__day <?= $first . $class ?>"
              data-day="<?= date('j', $day) ?>" data-fulldate="<?=date('Y-m-d', $day)?>">
            <span class="page-nav__day-week"><?= $dayWeek ?></span><span
                    class="page-nav__day-number"><?= date('j', $day) ?></span>
        </span>
        <?php $first = '';
    endfor; ?>
</nav>
<?
$allFilms = $db->selectWhere('films', ['id', 'name', 'duration', 'poster', 'description', 'country'], []);
?>
<main>
    <? foreach ($allFilms as $film): ?>
        <section class="movie">
            <div class="movie__info">
                <div class="movie__poster">
                    <img class="movie__poster-image" alt="<?= $film['name'] ?> постер" src="<?= $film['poster'] ?>">
                </div>
                <div class="movie__description">
                    <h2 class="movie__title"><?= $film['name'] ?></h2>
                    <p class="movie__synopsis"><?= $film['description'] ?></p>
                    <p class="movie__data">
                        <span class="movie__data-duration"><?= $film['duration'] ?> минут</span>
                        <span class="movie__data-origin"><?= $film['country'] ?></span>
                    </p>
                </div>
            </div>

            <?
            $arFilmGrid = [];
            $filmSeances = $db->selectWhere('seances', ['id', 'hall_id', 'time_start'], ['film_id' => $film['id']]);
            $filmHalls = [];
            foreach ($filmSeances as $seance) {
                if (!isset($filmHalls[$seance['hall_id']])) {
                    $filmHall = $db->selectWhere('halls', ['name', 'status'], ['id' => $seance['hall_id']])[0];
                    $filmHalls[$seance['hall_id']] = [
                        'status' => $filmHall['status'],
                        'name' => $filmHall['name']
                    ];
                }
                if ($filmHalls[$seance['hall_id']]['status'] == 1) {
                    $arFilmGrid[$seance['hall_id']][] = [
                        'id' => $seance['id'],
                        'time_start' => $seance['time_start']
                    ];
                }
            }
            foreach ($arFilmGrid as $hallID => $seances):?>
                <div class="movie-seances__hall">
                    <h3 class="movie-seances__hall-title"><?= $filmHalls[$hallID]['name'] ?></h3>
                    <ul class="movie-seances__list">
                        <?
                        usort($seances, "cmp");
                        foreach ($seances as $seance):?>
                            <li class="movie-seances__time-block">
                                <?$timeClass = 'movie-seances__time';
                                if($seance['time_start'] < date('H:i'))
                                    $timeClass = 'movie-seances__time-disabled';?>
                                <a class="<?=$timeClass?>" data-seanceid="<?= $seance['id'] ?>" data-filmid="<?= $film['id'] ?>" data-seancetime="<?= $seance['time_start'] ?>"><?= $seance['time_start'] ?></a>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
            <? endforeach; ?>
        </section>
    <? endforeach; ?>
</main>

</body>
<script src="js/index.js"></script>
</html>