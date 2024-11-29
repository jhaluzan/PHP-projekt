<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

$query = "SELECT * FROM vijesti WHERE arhiva = 'N' ORDER BY datum DESC";
$result = mysqli_query($conn, $query);

print '
<section id="news-section" class="news-container">
<h1>News</h1>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $news_url = 'news_details.php?id=' . $row['id'];

        print '
        <article class="news-item">
            <figure>
                <a href="' . $news_url . '"><img src="' . $row['slika'] . '" alt="Slika vijesti"></a>
            </figure>
            <div class="news-content">
                <h2><a href="' . $news_url . '">' . htmlspecialchars($row['naslov']) . '</a></h2>
                <p>' . htmlspecialchars(substr($row['tekst'], 0, 200)) . '...</p>
                <p class="date">Datum: ' . $row['datum'] . '</p>
                <a href="' . $news_url . '" class="read-more">More...</a>
            </div>
        </article>';
    }
} else {
    print '<p>Trenutno nema vijesti za prikaz.</p>';
}

print '</section>';

mysqli_close($conn);
?>