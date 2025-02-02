<?php
$baza_serwer = "localhost";
$baza_uzytkownik = "root";
$baza_haslo = "";
$baza_nazwa = "infprog21";

$login ="";
$haslo ="";


function get_haslo_login()
{
    global $login;
    global $haslo;

    if (isset($_GET["haslo"])) {
        // Если параметр "haslo" передан, присваиваем его переменной $haslo
        $haslo = $_GET["haslo"];
    } else {
        // Если параметра "haslo" нет, присваиваем пустую строку
        $haslo = "";
    }

    if (isset($_GET["login"])) {
        // Если параметр "login" передан, присваиваем его переменной $login
        $login = $_GET["login"];
    } else {
        // Если параметра "login" нет, присваиваем пустую строку
        $login = "";
    }
}

 ?>


