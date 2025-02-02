<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1, initial-scale=1.0">
    <title>LOGIN DB</title>
</head>
<body>
<?php
    //Используется два раза require_once для подключения файлов PHP
    include_once "dane.php";
    //это dane.php, где, хранятся данные для подключения к базе данных
    // Важно, что мы используем require_once для того, чтобы файл подключался только один раз.
?>
<!-- ____________________________________________________________________ -->
<?php





get_haslo_login();


if (($login=="") or ($haslo=="")){


    echo <<<START
<div class="" id="okno_logowania">
    <p class="p_login">

    <label for="login">podai login:</label>
    <input type="login" id="login" name="login" placeholder="podaj login"></input></p>

<p class="p_zaloguj">
<label for="haslo">podaj haslo</label>
<input type="password" id="haslo" name="haslo" placeholder="wpisz haslo">
</p>
<p class="p_zaloguj">
    <input type="button" value="Zaloguj" id="bt_zaloguj" onclick="logowanie()">
</p>
</div>





<script src="js/hash.js"></script>
<script>

// Функция, которая вызывается при нажатии кнопки "Zaloguj"
    
function logowanie() {
        // Получаем значение логина из поля ввода с id="login"

        let haslo_ = document.getElementById('haslo').value;

        // Получаем значение пароля из поля ввода с id="haslo"

        let login_ = document.getElementById('login').value;
        haslo_=md5(haslo_)
        // Перенаправляем браузер на страницу "logowanie.php", передавая параметры логина и пароля через URL
        // Используется window.location.href для редиректа

        window.location.href = "php/logowanie.php?haslo=" + haslo_ + "&login=" + login_;
    }

    </script>
START;
}

else {
    echo " zalogowane";
};

?>

</body>
</html>