<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nvidia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../db_connection.php');
include('../cms_pristup.php'); 

if ($_SESSION['korisnik']['rola'] != 1) {
    die("Pristup nije dozvoljen.");
}

if (isset($_POST['edit'])) {
    $rola = (int)$_POST['rola'];
    $pristup = $_POST['pristup'];
    $userId = (int)$_POST['edit'];

    $query = "UPDATE korisnici SET rola = $rola, pristup = '$pristup' WHERE id = $userId";
    if (mysqli_query($conn, $query)) {
        echo '<p>Podaci o korisniku su ažurirani.</p>';
        if ($userId == $_SESSION['korisnik']['id']) {
            $_SESSION['korisnik']['rola'] = $rola;
            $_SESSION['korisnik']['pristup'] = $pristup;
        }
    } else {
        echo '<p>Greška prilikom ažuriranja: ' . mysqli_error($conn) . '</p>';
    }
}

$query = "SELECT * FROM korisnici";
$result = mysqli_query($conn, $query);

echo "<h3>Lista korisnika:</h3>";
echo "<table border='1'>";
echo "<tr><th>Ime</th><th>Prezime</th><th>Email</th><th>Rola</th><th>Pristup</th><th>Akcija</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['ime']}</td>
            <td>{$row['prezime']}</td>
            <td>{$row['email']}</td>
            <td>{$row['rola']}</td>
            <td>{$row['pristup']}</td>
            <td>
                <form method='post'>
                    <input type='hidden' name='edit' value='{$row['id']}'>
                    <label>Rola:</label>
                    <select name='rola'>
                        <option value='1' " . ($row['rola'] == 1 ? 'selected' : '') . ">Administrator</option>
                        <option value='2' " . ($row['rola'] == 2 ? 'selected' : '') . ">Editor</option>
                        <option value='3' " . ($row['rola'] == 3 ? 'selected' : '') . ">User</option>
                    </select>
                    <label>Pristup:</label>
                    <select name='pristup'>
                        <option value='Y' " . ($row['pristup'] == 'Y' ? 'selected' : '') . ">Da</option>
                        <option value='N' " . ($row['pristup'] == 'N' ? 'selected' : '') . ">Ne</option>
                    </select>
                    <button type='submit'>Ažuriraj</button>
                </form>
            </td>
          </tr>";
}
echo "</table>";

mysqli_close($conn);
?>

<p><a href="http://localhost/projekt/index.php?menu=8">Vrati se</a></p>