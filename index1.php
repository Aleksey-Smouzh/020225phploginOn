<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN DB</title>
</head>
<body>

<?php
// Подключаем файл с данными для соединения с базой данных
include_once "dane.php";

// Вызываем функцию для получения логина и пароля из URL-параметров
get_haslo_login();

// Проверяем, переданы ли логин и пароль в URL-параметрах
if (($login == "") or ($haslo == "")) {
    // Если логин и пароль не переданы, показываем форму авторизации
    echo <<<START
    <link rel="stylesheet" href="style.css">
    <div class="" id="okno_logowania">
        <p class="p_login">
            <label for="login">Podaj login:</label>
            <input type="text" id="login" name="login" placeholder="podaj login">
        </p>
        <p class="p_zaloguj">
            <label for="haslo">Podaj hasło:</label>
            <input type="password" id="haslo" name="haslo" placeholder="wpisz hasło">
        </p>
        <p class="p_zaloguj">
            <input class="btn" type="button" value="Zaloguj" id="bt_zaloguj" onclick="logowanie()">
        </p>
    </div>
    
    <!-- Подключаем скрипт для хеширования пароля -->
    <script src="js/hash.js"></script>
    
    <script>
        // Функция, которая вызывается при нажатии кнопки "Zaloguj"
        function logowanie() {
            // Получаем введенные пользователем логин и пароль
            let haslo_ = document.getElementById('haslo').value;
            let login_ = document.getElementById('login').value;

            // Хешируем логин и пароль перед отправкой на сервер
            haslo_ = md5(haslo_) + sha1(haslo_);
            login_ = sha1(login_) + md5(login_);

            // Перенаправляем пользователя на страницу logowanie.php с параметрами логина и пароля
            window.location.href = "php/logowanie.php?haslo=" + haslo_ + "&login=" + login_;
        }
    </script>
START;
} else {
    // Если логин и пароль переданы, проверяем идентификатор сотрудника
    $id_pracownika = get_hash_parametr("id_pracownika");

    // Проверяем, есть ли у нас ID сотрудника
    if ($id_pracownika != "") {
        // Подключаемся к базе данных
        $baza = mysqli_connect($baza_serwer, $baza_uzytkownik, $baza_haslo, $baza_nazwa);
        
        // Если соединение с базой данных не удалось, выводим сообщение об ошибке и прерываем выполнение кода
        if (!$baza) {
            die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
        }

        // Формируем SQL-запрос для получения имени, фамилии и уровня доступа сотрудника из таблицы prawa
        $sql = "SELECT pracownicy.NAZWISKO, imiona.IMIE, prawa.PRAWA 
                FROM pracownicy 
                INNER JOIN imiona ON pracownicy.id = imiona.id 
                INNER JOIN logowanie ON pracownicy.id = logowanie.id_pracownika 
                INNER JOIN prawa ON logowanie.PRAWA = prawa.ID
                WHERE pracownicy.id = '$id_pracownika'";

        // Выполняем SQL-запрос
        $wynik = mysqli_query($baza, $sql);

        // Проверяем, найден ли сотрудник в базе данных
        if ($wynik && mysqli_num_rows($wynik) > 0) {
            // Получаем данные сотрудника
            $wiersz = mysqli_fetch_assoc($wynik);
            
            // Выводим приветствие с именем, фамилией и уровнем доступа сотрудника
            echo "Witaj, {$wiersz['IMIE']} {$wiersz['NAZWISKO']}! Twój poziom dostępu: {$wiersz['PRAWA']}";
        } else {
            // Если сотрудник не найден, выводим сообщение
            echo "Nie znaleziono użytkownika.";
        }

        // Закрываем соединение с базой данных
        mysqli_close($baza);
    } else {
        // Если ID сотрудника отсутствует, перенаправляем пользователя обратно на страницу входа
        header("location: index.php?login=&haslo=");
    }
}
?>

</body>
</html>
