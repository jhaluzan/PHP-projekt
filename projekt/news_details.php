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

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $news_id = intval($_GET['id']);

    $query = "SELECT * FROM vijesti WHERE id = $news_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        echo '
    <section id="news-section">
        <h1>' . htmlspecialchars($row['naslov']) . '</h1>
        
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <figure>
                <img src="' . htmlspecialchars($row['slika']) . '" alt="Slika vijesti">
            </figure>';

            $vise_slika = $row['vise_slika'];
            if (!empty($vise_slika)) {
                $slike = explode(',', $vise_slika);
                foreach ($slike as $slika_url) {
                    echo '<figure>
                            <img src="' . htmlspecialchars($slika_url) . '" alt="Više slika">
                          </figure>';
                }
            }
        echo '</div>';

        echo '
        <div class="news-content">
            <p class="date">Datum: ' . htmlspecialchars($row['datum']) . '</p>
            <p>' . nl2br(htmlspecialchars($row['tekst'])) . '</p>
        </div>
    </section>';
    } else {
        echo '<p>Vijest nije pronađena.</p>';
    }
} else {
    echo '<p>Greška</p>';
}

mysqli_close($conn);
?>

<footer class="footer">
        <p>Copyright &copy; 2024 Jan Halužan.
            <a href="https://github.com/jhaluzan"><img src="images/github.png" alt="Github"></a>
        </p>
    </footer>
</body>
</html>