<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php include_once "../dane.php"; ?>

    <title>logowanie</title>
</head>
<body>


<?php

    // Вызываем функцию get_haslo_login(), которая,  предназначена для получения значений логина и пароля
    // Она может быть определена ранее в коде или в подключенном файле она присваивает значения переменным $login и $haslo.
    get_haslo_login();
    $login = login($login);
    $haslo = haslo($haslo);
    // echo "haslo_hash=$haslo";
    // echo "login_hash=$login";
    // exit;

    // Создаем соединение с базой данных с помощью функции mysqli_connect().
    // Передаем параметры для подключения к базе данных: сервер, пользователь, пароль, название базы данных.
    // Переменные $baza_serwer, $baza_uzytkownik, $baza_haslo, $baza_nazwa должны быть определены где-то в коде
    // или в подключаемом файле (например, в "dane.php").
    $baza = mysqli_connect($baza_serwer, $baza_uzytkownik, $baza_haslo, $baza_nazwa);

    // Создаем SQL-запрос для проверки, существует ли пользователь с заданным логином и паролем.
    // Запрос выбирает логин, пароль и id_pracownika из таблицы logowanie.
    // Примечание: это может быть уязвимостью SQL-инъекций, так как данные напрямую вставляются в запрос.
    $sql = "select login_hash,haslo,id_pracownika from logowanie where login_hash='$login' and haslo='$haslo'";

    // Выполняем SQL-запрос с помощью функции mysqli_query(), которая возвращает результат запроса.
    // Этот результат сохраняется в переменной $wynik.
    $wynik = mysqli_query($baza, $sql);

    // Проверяем, сколько строк было найдено в результате запроса с помощью mysqli_num_rows().
    // Если найдено 1 строка, это означает, что логин и пароль совпадают с тем, что хранится в базе данных.
    if (mysqli_num_rows($wynik) == 1) {
        // Если логин и пароль совпадают, получаем id_pracownika из результата запроса
        // Мы используем mysqli_fetch_array() для извлечения данных из результата в виде массива.
        $id = mysqli_fetch_array($wynik)["id_pracownika"];

        // Закрываем соединение с базой данных, так как запрос завершен.
        mysqli_close($baza);

        // Выполняем редирект на страницу index.php с параметрами login и haslo, которые были переданы в запросе.
        // Это может быть полезно, например, для отслеживания информации о пользователе.
        // Примечание: передача пароля через URL не является безопасным, лучше использовать метод POST.
        // header("location:../index.php?login=$login&haslo=$haslo");
        // mysqli_close($baza);

        header("location:../index.php?" . parametr('id_pracownika' . $id) . "=$id&" . parametr('login' . $login) . "=$login&" . parametr('haslo' . $haslo) . "=$haslo");

    } else {
        // Если логин и пароль не совпадают, закрываем соединение с базой данных.
        mysqli_close($baza);

        // Выполняем редирект на страницу index.php, но без передачи логина и пароля.
        // Это может сигнализировать, что произошла ошибка при аутентификации.
        header("location:../index.php?login=&haslo=");
    }

?>

</body>
</html>
