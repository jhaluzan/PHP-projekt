<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $k_ime = $_POST['k_ime'];
    $lozinka = $_POST['lozinka'];

    $sql = "SELECT * FROM korisnici WHERE k_ime='$k_ime'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $korisnik = $result->fetch_assoc();
        
        if ($korisnik['pristup'] == 'N') {
            $_SESSION['message'] = "Vaš nalog nije aktivan. Obratite se administratoru.";
            header("Location: index.php?menu=7");
            exit();
        }

        if (password_verify($lozinka, $korisnik['lozinka'])) {
            $_SESSION['korisnik'] = $korisnik;
            $_SESSION['korisnik']['valid'] = 'true';
            $_SESSION['message'] = "Uspješno ste prijavljeni!";
            header("Location: index.php?menu=7");
            exit();
        } else {
            $_SESSION['message'] = "Neispravna lozinka!";
            header("Location: index.php?menu=7");
            exit();
        }
    } else {
        $_SESSION['message'] = "Korisničko ime ne postoji!";
        header("Location: index.php?menu=7");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Prijava</h1>
        <form action="login.php" method="post" class="form">
            <label for="k_ime">Korisničko ime:</label>
            <input type="text" name="k_ime" id="k_ime" required>
            <br><br>
            <label for="lozinka">Lozinka:</label>
            <input type="password" name="lozinka" id="lozinka" required>
            <br><br>
            <button type="submit">Prijavi se</button>
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