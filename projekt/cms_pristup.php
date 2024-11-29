<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

if (!isset($_SESSION['korisnik'])) {
    die("Niste prijavljeni.");
}

$rolaKorisnika = $_SESSION['korisnik']['rola'];
$pristupKorisnik = $_SESSION['korisnik']['pristup'];

if ($pristupKorisnik != 'Y') {
    die("Vaš nalog nije aktivan. Obratite se administratoru.");
}

switch ($rolaKorisnika) {
    case 1: // Administrator
        break;
    case 2: // Editor
        if (basename($_SERVER['PHP_SELF']) == 'korisnici.php') {
            die("Nemate pristup ovoj stranici.");
        }
        break;
    case 3: // User
        if (basename($_SERVER['PHP_SELF']) == 'korisnici.php') {
            die("Nemate pristup ovoj stranici.");
        }
        break;
    default:
        die("Nepoznata uloga korisnika.");
}
?>