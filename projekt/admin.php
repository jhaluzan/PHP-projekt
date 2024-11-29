<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

if (!isset($_SESSION['korisnik']) || $_SESSION['korisnik']['pristup'] != 'Y') {
    die("Pristup nije dozvoljen ili vaš nalog nije aktivan.");
}

$rolaKorisnika = $_SESSION['korisnik']['rola'];

echo "<div class=container>";
echo "<h1>Administracija</h1>";
echo "<ul class='admin'>";

// Administrator
if ($rolaKorisnika == 1) {
    echo "<h2>Administrator</h2>";
    echo "<li class='admin-item'><a id='admin-users' class='admin-link' href='admin/korisnici.php'>Korisnici</a></li>";
    echo "<li class='admin-item'><a id='admin-news' class='admin-link' href='admin/vijesti.php'>Vijesti</a></li>";
}
// Editor
elseif ($rolaKorisnika == 2) {
    echo "<h2>Editor</h2>";
    echo "<li class='admin-item'><a id='editor-news' class='admin-link' href='admin/vijesti.php'>Vijesti</a></li>";
}
// User
elseif ($rolaKorisnika == 3) {
    echo "<h2>User</h2>";
    echo "<li class='admin-item'><a id='user-add-news' class='admin-link' href='admin/vijesti.php'>Vijesti</a></li>";
}

echo "</ul>";
echo "</div>";

mysqli_close($conn);
?>