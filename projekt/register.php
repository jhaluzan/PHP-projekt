<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $drzava = $_POST['drzava'];
    $grad = $_POST['grad'];
    $ulica = $_POST['ulica'];
    $datum_rod = $_POST['datum_rod'];
    $k_ime = $_POST['k_ime'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);

    $korisnicko_ime = strtolower($ime[0] . $prezime);
    $counter = 1;
    $original_korisnicko_ime = $korisnicko_ime;

    while (true) {
        $check_username = "SELECT * FROM korisnici WHERE k_ime = '$korisnicko_ime'";
        $result = mysqli_query($conn, $check_username);
        if (mysqli_num_rows($result) == 0) {
            break;
        }
        $korisnicko_ime = $original_korisnicko_ime . $counter;
        $counter++;
    }

    $query = "INSERT INTO korisnici (ime, prezime, email, drzava, grad, ulica, datum_rod, k_ime, lozinka)
              VALUES ('$ime', '$prezime', '$email', '$drzava', '$grad', '$ulica', '$datum_rod', '$korisnicko_ime', '$lozinka')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Registracija uspješna! Vaše korisničko ime je: <strong>$korisnicko_ime</strong>";
        header("Location: index.php?menu=6");
        exit();
    } else {
        $_SESSION['message'] = "Greška pri registraciji: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Registracija</h1>
        <form method="POST" action="" class="form">
            <label for="ime">Ime:</label>
            <input type="text" name="ime" id="ime" required>
            <br><br>
            <label for="prezime">Prezime:</label>
            <input type="text" name="prezime" id="prezime" required>
            <br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br><br>
            <label for="drzava">Država:</label>
            <select name="drzava" id="drzava" required>
                <?php
                $drzave_query = "SELECT * FROM drzave";
                $drzave_result = mysqli_query($conn, $drzave_query);
                while ($row = mysqli_fetch_assoc($drzave_result)) {
                    $selected = ($row['country_code'] === 'HR') ? 'selected' : '';
                    echo "<option value='{$row['country_code']}' $selected>{$row['country_name']}</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="grad">Grad:</label>
            <input type="text" name="grad" id="grad" required>
            <br><br>
            <label for="ulica">Ulica:</label>
            <input type="text" name="ulica" id="ulica" required>
            <br><br>
            <label for="datum_rod">Datum rođenja:</label>
            <input type="date" name="datum_rod" id="datum_rod" required>
            <br><br>
            <label for="k_ime">Korisničko ime:</label>
            <input type="k_ime" name="k_ime" id="k_ime" required>
            <br><br>
            <label for="lozinka">Lozinka:</label>
            <input type="password" name="lozinka" id="lozinka" required>
            <br><br>
            <button type="submit">Registriraj se</button>
        </form>

        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>
    </div>
</body>
</html>