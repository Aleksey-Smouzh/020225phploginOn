<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->

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

    //$x = md5('test').sha1('test');
    //   echo sha1(md5($x)).md5(sha1($x));
    //echo login($x);
    //exit;
    get_haslo_login();

    if (($login == "") or ($haslo == "")) {

        echo <<<START
        <link rel="stylesheet" href="style.css">
<div class="" id="okno_logowania">
    <p class="p_login">

    <label for="login">Podaj login:</label>
    <input type="login" id="login" name="login" placeholder="  podaj login"></input></p>

<p class="p_zaloguj">
<label for="haslo">Podaj haslo:</label>
<input type="password" id="haslo" name="haslo" placeholder="  wpisz haslo">
</p>
<p class="p_zaloguj">
    <input class="btn" type="button" value="Zaloguj" id="bt_zaloguj" onclick="logowanie()">
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


        haslo_=md5(haslo_)+sha1(haslo_);
        login_=sha1(login_)+md5(login_);


        // Перенаправляем браузер на страницу "logowanie.php", передавая параметры логина и пароля через URL
        // Используется window.location.href для редиректа

         window.location.href = "php/logowanie.php?haslo=" + haslo_ + "&login=" + login_;


        // window.open("php/logowanie.php?haslo=" + haslo_ + "&login=" + login_, '_blank');
    }

    </script>
START;
    } else {
        $id_pracownika = get_hash_parametr("id_pracownika");
        if ($id_pracownika != "") {
            $baza   = mysqli_connect($baza_serwer, $baza_uzytkownik, $baza_haslo, $baza_nazwa);
            $sql    = "select * from pracownicy,imiona where pracownicy.id='$id_pracownika' and imiona.id='$id_pracownika'";
            $wynik  = mysqli_query($baza, $sql);
            $wiersz = mysqli_fetch_array($wynik);
            echo "{$wiersz['NAZWISKO']} {$wiersz['IMIE']}";
            mysqli_close($baza);
        } else {
            header("location: index.php?login=&haslo=");
        }

    }
?>

</body>
</html>