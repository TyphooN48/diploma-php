<? require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';
if (!isset($_POST['seats']) && !isset($_POST['film_id']) && !isset($_POST['seance_id']) && !isset($_POST['date'])) {
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
    <section class="ticket">

        <header class="tichet__check">
            <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
        </header>
        <?$film = $db->selectWhere('films', ['name'], ['id' => (int)$_POST['film_id']])[0];
        $seance = $db->selectWhere('seances', ['time_start', 'hall_id'], ['id' => (int)$_POST['seance_id']])[0];
        $hall = $db->selectWhere('halls', ['name', 'grid', 'cost'], ['id' => $seance['hall_id']])[0];
        $cost = 0;
        $seats = '';
        $seatsArr = explode(',', $_POST['seats']);
        $hallCost = json_decode($hall['cost'], true);
        $hallGrid = json_decode($hall['grid'], true)['grid'];
        foreach ($seatsArr as $seat) {
            $seats .= ((int)$seat + 1) . ', ';
            switch ($hallGrid[$seat]) {
                case 1:
                    $cost += $hallCost['standart'];
                    break;
                case 2:
                    $cost += $hallCost['vip'];
                    break;
            }
        }
        $seats = rtrim($seats, ', ');
        ?>
        <div class="ticket__info-wrapper">
            <p class="ticket__info">На фильм: <span class="ticket__details ticket__title"><?= $film['name'] ?></span>
            </p>
            <p class="ticket__info">Места: <span class="ticket__details ticket__chairs"><?=$seats?></span></p>
            <p class="ticket__info">В зале: <span class="ticket__details ticket__hall"><?= $hall['name'] ?></span></p>
            <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start"><?= $seance['time_start'] ?></span></p>
            <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost"><?=$cost?></span> рублей</p>
            <form method="post" action="/client/ticket.php">
                <input type="hidden" name="seance_id" value="<?=$_POST['seance_id']?>">
                <input type="hidden" name="film_id" value="<?=$_POST['film_id']?>">
                <input type="hidden" name="hall_id" value="<?=$seance['hall_id']?>">
                <input type="hidden" name="seats" value="<?=$_POST['seats']?>">
                <input type="hidden" name="date" value="<?=$_POST['date']?>">
                <button class="acceptin-button" type="submit">Получить код бронирования</button>
            </form>

            <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите
                QR-код нашему контроллёру у входа в зал.</p>
            <p class="ticket__hint">Приятного просмотра!</p>
        </div>
    </section>
</main>

</body>
</html>