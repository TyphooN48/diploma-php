<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация | ИдёмВКино</title>
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

<main>
    <section class="login">
        <header class="login__header">
            <h2 class="login__title">Авторизация</h2>
        </header>
        <div class="login__wrapper">
            <form class="login__form" method="POST" accept-charset="utf-8" id="authForm">
                <label class="login__label" for="email">
                    E-mail
                    <input class="login__input" type="email" placeholder="example@domain.xyz" name="email" required>
                </label>
                <label class="login__label" for="pwd">
                    Пароль
                    <input class="login__input" type="password" placeholder="" name="password" required>
                </label>
                <p class="text-center" style="color: red; display: none" id="errText"></p>
                <div class="text-center">
                    <input value="Авторизоваться" type="submit" class="login__button">
                </div>
            </form>
        </div>
    </section>
</main>

<script src="js/accordeon.js"></script>

<script>
    authForm.onsubmit = async (e) => {
        e.preventDefault()
        const errP = document.getElementById('errText')

        let response = await fetch('/api/auth.php', {
            method: 'POST',
            body: new FormData(authForm)
        })
        let result = await response.json()

        if(result.status) {
            errP.style.display = 'none'
            errP.innerText = ''
            window.location.replace("/admin/")
        } else {
            errP.style.display = 'block'
            errP.innerText = result.mess
        }
    };
</script>
</body>
</html>
