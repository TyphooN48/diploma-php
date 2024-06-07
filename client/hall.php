<? require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';
if (!isset($_POST['film_id']) && !isset($_POST['seance_id']) && !isset($_POST['date'])) {
    header("Location: /client/");
}
?>
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

<main>
    <section class="buying">
        <div class="buying__info">
            <div class="buying__info-description">
                <? $film = $db->selectWhere('films', ['name'], ['id' => (int)$_POST['film_id']])[0];
                $seance = $db->selectWhere('seances', ['id', 'time_start', 'hall_id'], ['id' => (int)$_POST['seance_id']])[0];
                $hall = $db->selectWhere('halls', ['id', 'name', 'grid', 'cost'], ['id' => $seance['hall_id']])[0]; ?>
                <h2 class="buying__info-title"><?= $film['name'] ?></h2>
                <p class="buying__info-start">Начало сеанса: <?= $seance['time_start'] ?></p>
                <p class="buying__info-hall"><?= $hall['name'] ?></p>
            </div>
            <div class="buying__info-hint">
                <p>Тапните дважды,<br>чтобы увеличить</p>
            </div>
        </div>
        <div class="buying-scheme">
            <div class="buying-scheme__wrapper">
                <? $hallgrid = json_decode($hall['grid'], true);
                $placeType = [
                    0 => 'disabled',
                    1 => 'standart',
                    2 => 'vip'];
                for ($i = 1; $i <= $hallgrid['rows']; $i++): ?>
                    <div class="buying-scheme__row">
                        <? for ($j = 1; $j <= $hallgrid['places']; $j++):
                            $gridPlace = $hallgrid['places'] * ($i - 1) + $j - 1;
                            $chairType = $placeType[$hallgrid['grid'][$gridPlace]];
                            if(count($db->selectWhere('tickets', ['id'], [
                                    'hall_id' => $hall['id'],
                                    'seance_id' => $seance['id'],
                                    'seat_id' => $gridPlace,
                                    'date' => "'" . $_POST['date'] . "'"])) >= 1)
                                $chairType = 'taken';
                            ?>
                            <span class="buying-scheme__chair buying-scheme__chair_<?=$chairType?>"
                                  data-seatid="<?=$gridPlace?>" data-seattype="<?=$chairType?>"></span>
                        <?endfor; ?>
                    </div>
                <? endfor; ?>
            </div>
            <div class="buying-scheme__legend">
                <div class="col">
                    <?$hallCost = json_decode($hall['cost'], true);?>
                    <p class="buying-scheme__legend-price"><span
                                class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span
                                class="buying-scheme__legend-value"><?=$hallCost['standart']?></span>руб)</p>
                    <p class="buying-scheme__legend-price"><span
                                class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span
                                class="buying-scheme__legend-value"><?=$hallCost['vip']?></span>руб)</p>
                </div>
                <div class="col">
                    <p class="buying-scheme__legend-price"><span
                                class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
                    <p class="buying-scheme__legend-price"><span
                                class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
                </div>
            </div>
        </div>
        <input type="hidden" value="<?=$_POST['film_id']?>" name="film_id">
        <input type="hidden" value="<?=$_POST['seance_id']?>" name="seance_id">
        <input type="hidden" value="<?=$_POST['date']?>" name="date">
        <button class="acceptin-button" disabled>Забронировать</button>
    </section>
</main>
<script src="js/hall.js"> </script>
</body>
</html>