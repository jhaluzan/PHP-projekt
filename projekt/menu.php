<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
print '
    <ul>
        <li><a href="index.php?menu=1">Početna</a></li>
        <li><a href="index.php?menu=2">Novosti</a></li>
        <li><a href="index.php?menu=3">Kontakt</a></li>
        <li><a href="index.php?menu=4">O nama</a></li>
        <li><a href="index.php?menu=5">Galerija</a></li>';
        if (!isset($_SESSION['korisnik']['valid']) || $_SESSION['korisnik']['valid'] == 'false') {
            print '
            <li><a href="index.php?menu=6">Registracija</a></li>
            <li><a href="index.php?menu=7">Prijava</a></li>';
        }
        else if ($_SESSION['korisnik']['valid'] == 'true') {
            print '
            <li><a href="index.php?menu=8">Admin</a></li>
            <li><a href="logout.php">Odjava</a></li>';
        }
print '
    </ul>';
?>