<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nvidia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
session_start();
include('../db_connection.php');
include('../cms_pristup.php');

// Provjera pristupa
if (!isset($_SESSION['korisnik']) || $_SESSION['korisnik']['pristup'] != 'Y') {
    die("Pristup nije dozvoljen ili vaš nalog nije aktivan.");
}

// Dodavanje nove vijesti
if (isset($_POST['add_news'])) {
    $naslov = mysqli_real_escape_string($conn, $_POST['naslov']);
    $tekst = mysqli_real_escape_string($conn, $_POST['tekst']);
    $slika = mysqli_real_escape_string($conn, $_POST['slika']);
    $vise_slika = mysqli_real_escape_string($conn, $_POST['vise_slika']);
    $arhiva_status = ($_SESSION['korisnik']['rola'] == 3) ? 'Y' : 'N';

    $query = "INSERT INTO vijesti (naslov, tekst, slika, arhiva, vise_slika) VALUES ('$naslov', '$tekst', '$slika', '$arhiva_status', '$vise_slika')";
    if (mysqli_query($conn, $query)) {
        if ($arhiva_status == 'Y') {
            echo "Vijest je uspješno dodana, ali je arhivirana do odobrenja.";
        } else {
            echo "Vijest je uspješno dodana i odmah odobrena.";
        }
    } else {
        echo "Greška prilikom dodavanja vijesti: " . mysqli_error($conn);
    }
}

// Izmjena vijesti
if (isset($_POST['update_news']) && $_SESSION['korisnik']['rola'] <= 2) {
    $newsId = (int)$_POST['news_id'];
    $naslov = mysqli_real_escape_string($conn, $_POST['naslov']);
    $tekst = mysqli_real_escape_string($conn, $_POST['tekst']);
    $slika = mysqli_real_escape_string($conn, $_POST['slika']);
    $vise_slika = mysqli_real_escape_string($conn, $_POST['vise_slika']);

    $query = "UPDATE vijesti SET naslov = '$naslov', tekst = '$tekst', slika = '$slika', vise_slika = '$vise_slika' WHERE id = $newsId";
    if (mysqli_query($conn, $query)) {
        echo "Vijest je uspješno izmijenjena.";
    } else {
        echo "Greška prilikom izmjene vijesti: " . mysqli_error($conn);
    }
}

// Brisanje vijesti
if (isset($_POST['delete']) && $_SESSION['korisnik']['rola'] == 1) {
    $newsId = (int)$_POST['delete'];
    $query = "DELETE FROM vijesti WHERE id = $newsId";
    if (mysqli_query($conn, $query)) {
        echo "Vijest je uspješno obrisana.";
    } else {
        echo "Greška prilikom brisanja vijesti: " . mysqli_error($conn);
    }
}

// Arhiviranje vijesti
if (isset($_POST['arhiva']) && $_SESSION['korisnik']['rola'] <= 2) {
    $newsId = (int)$_POST['arhiva'];
    $query = "UPDATE vijesti SET arhiva = 'Y' WHERE id = $newsId";
    if (mysqli_query($conn, $query)) {
        echo "Vijest je arhivirana.";
    } else {
        echo "Greška prilikom arhiviranja vijesti: " . mysqli_error($conn);
    }
}

// Odobravanje vijesti
if (isset($_POST['approve']) && $_SESSION['korisnik']['rola'] == 1) {
    $newsId = (int)$_POST['approve'];
    $query = "UPDATE vijesti SET arhiva = 'N' WHERE id = $newsId";
    if (mysqli_query($conn, $query)) {
        echo "Vijest je odobrena.";
    } else {
        echo "Greška prilikom odobravanja vijesti: " . mysqli_error($conn);
    }
}

// Forma za izmjenu vijesti
if (isset($_GET['edit_news_id'])) {
    $newsId = (int)$_GET['edit_news_id'];
    $query = "SELECT * FROM vijesti WHERE id = $newsId";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        ?>
        <form method="post">
            <h2>Izmjeni vijest:</h2>
            <input type="hidden" name="news_id" value="<?= $row['id'] ?>">
            <label>Naslov:</label>
            <input type="text" name="naslov" value="<?= $row['naslov'] ?>" required><br><br>
            <label>Tekst:</label>
            <textarea name="tekst" required><?= $row['tekst'] ?></textarea><br><br>
            <label>Slika:</label>
            <input type="text" name="slika" value="<?= $row['slika'] ?>" required><br><br>
            <label>Više slika (odvojene zarezima):</label>
            <input type="text" name="vise_slika" value="<?= $row['vise_slika'] ?>"><br><br>
            <button type="submit" name="update_news">Izmjeni vijest</button>
        </form>
        <?php
    }
}

// Prikaz liste vijesti
$query = "SELECT * FROM vijesti";
$result = mysqli_query($conn, $query);

echo "<h2>Lista vijesti:</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<h4>{$row['naslov']}</h4>";
    echo "<p>{$row['tekst']}</p>";
    echo "<img src='../{$row['slika']}' alt='Slika vijesti' style='width: 200px; height: 110px;'><br><br>";

    $vise_slika = $row['vise_slika'];
    if (!empty($vise_slika)) {
        $slike = explode(',', $vise_slika);
        foreach ($slike as $slika_url) {
            echo "<img src='../$slika_url' alt='Viša slika' style='width: 200px; height: 110px;'><br><br>";
        }
    }

    if ($_SESSION['korisnik']['rola'] == 1) {
        echo "<form method='post' style='display:inline;'>
                <input type='hidden' name='delete' value='{$row['id']}' />
                <button type='submit'>Obriši</button>
              </form>";
        echo "<form method='post' style='display:inline;'>
                <input type='hidden' name='approve' value='{$row['id']}' />
                <button type='submit'>Odobri</button>
              </form>";
    }

    if ($_SESSION['korisnik']['rola'] <= 2) {
        echo "<form method='post' style='display:inline;'>
                <input type='hidden' name='arhiva' value='{$row['id']}' />
                <button type='submit'>Arhiviraj</button>
              </form>";
        echo "<form method='get' style='display:inline;'>
                <input type='hidden' name='edit_news_id' value='{$row['id']}' />
                <button type='submit'>Izmjeni</button>
              </form>";
    }

    echo "<hr>";
}

// Forma za dodavanje nove vijesti
if ($_SESSION['korisnik']['pristup'] == 'Y') {
    ?>
    <form method="post">
        <h2>Dodaj novu vijest:</h2>
        <label>Naslov:</label>
        <input type="text" name="naslov" required>&nbsp;&nbsp;&nbsp;
        <label>Tekst:</label>
        <textarea name="tekst" required></textarea>&nbsp;&nbsp;&nbsp;
        <label>Slika:</label>
        <input type="text" name="slika" required>&nbsp;&nbsp;&nbsp;
        <label>Više slika (odvojene zarezima):</label>
        <input type="text" name="vise_slika">&nbsp;&nbsp;&nbsp;
        <button type="submit" name="add_news">Dodaj vijest</button>
    </form>
    <?php
} else {
    echo "<p>Vaš nalog nije aktivan. Obratite se administratoru za pristup.</p>";
}

mysqli_close($conn);
?>
<br>
<p><a href="http://localhost/projekt/index.php?menu=8">Vrati se</a></p>
</body>
</html>