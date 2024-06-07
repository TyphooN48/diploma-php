<? require_once $_SERVER['DOCUMENT_ROOT'] . '/service/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/service/phpqrcode/qrlib.php";
if (!isset($_POST['seats']) && !isset($_POST['film_id']) && !isset($_POST['seance_id']) && !isset($_POST['hall_id']) && !isset($_POST['date'])) {
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
            <h2 class="ticket__check-title">Электронный билет</h2>
        </header>
        <?$film = $db->selectWhere('films', ['name'], ['id' => (int)$_POST['film_id']])[0];
        $seance = $db->selectWhere('seances', ['time_start', 'hall_id'], ['id' => (int)$_POST['seance_id']])[0];
        $hall = $db->selectWhere('halls', ['name', 'grid', 'cost'], ['id' => (int)$_POST['hall_id']])[0];
        $seats = '';
        $seatsArr = explode(',', $_POST['seats']);
        foreach ($seatsArr as $seat) {
            $addTicket = $db->insert('tickets', [
                'seat_id' => $seat,
                'hall_id' => (int)$_POST['hall_id'],
                'seance_id' => (int)$_POST['seance_id'],
                'date' => $_POST['date']
            ]);
            $seats .= ((int)$seat + 1) . ', ';
        }
        $seats = rtrim($seats, ', ');
        $QRtext = "Фильм: " . $film['name'] . PHP_EOL .
            "Зал: " . $hall['name'] . PHP_EOL .
            "Места: " . $seats . PHP_EOL .
            "Дата: " . date('d.m.Y', strtotime($_POST['date'])) . PHP_EOL .
            "Начало сеанса: " . $seance['time_start'];

        QRcode::png($QRtext, $_SERVER['DOCUMENT_ROOT'] . "/client/i/qr-code.png", "L", 4, 4);
        ?>
        <div class="ticket__info-wrapper">
            <p class="ticket__info">На фильм: <span class="ticket__details ticket__title"><?= $film['name'] ?></span>
            </p>
            <p class="ticket__info">Места: <span class="ticket__details ticket__chairs"><?=$seats?></span></p>
            <p class="ticket__info">В зале: <span class="ticket__details ticket__hall"><?= $hall['name'] ?></span></p>
            <p class="ticket__info">Дата: <span class="ticket__details ticket__date"><?= date('d.m.Y', strtotime($_POST['date'])) ?></span></p>
            <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start"><?= $seance['time_start'] ?></span></p>

            <img class="ticket__info-qr" src="/client/i/qr-code.png?<?=time()?>">

            <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
            <p class="ticket__hint">Приятного просмотра!</p>
        </div>
    </section>
</main>

</body>
</html>