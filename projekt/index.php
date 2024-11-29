<?php
session_start();
include('db_connection.php');

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
?>

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
    <header>
        <div class="banner"></div>
        <div <?php echo $menu > 1 ? 'class="hero-subimage"' : 'class="hero-image"'; ?>></div>
        <nav>
            <?php include("menu.php"); ?>
        </nav>
    </header>

    <main>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }

        if (!isset($menu) || $menu == 1) {
            include("home.php");
        } elseif ($menu == 2) {
            include("news.php");
        } elseif ($menu == 3) {
            include("contact.php");
        } elseif ($menu == 4) {
            include("about.php");
        } elseif ($menu == 5) {
            include("gallery.php");
        } elseif ($menu == 6) {
            include("register.php");
        } elseif ($menu == 7) {
            include("login.php");
        } elseif ($menu == 8) {
            include("admin.php");
        } elseif ($menu == 9) {
            include("logout.php");
        } else {
            include("home.php");
        }
        ?>
    </main>

    <footer class="footer">
        <p>Copyright &copy; 2024 Jan Halužan.
            <a href="https://github.com/jhaluzan"><img src="images/github.png" alt="Github"></a>
        </p>
    </footer>
</body>
</html>