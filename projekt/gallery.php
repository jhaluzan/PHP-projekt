<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

$query = "SELECT slika, vise_slika FROM vijesti";
$result = mysqli_query($conn, $query);

print '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Gallery</h1>
    <section class="gallery">';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['slika'])) {
            print '
            <figure class="gallery-item">
                <a href="' . htmlspecialchars($row['slika']) . '" target="_blank">
                    <img src="' . htmlspecialchars($row['slika']) . '">
                </a>
            </figure>';
        }

        if (!empty($row['vise_slika'])) {
            $slike = explode(',', $row['vise_slika']);
            foreach ($slike as $slika_url) {
                print '
                <figure class="gallery-item">
                    <a href="' . htmlspecialchars(trim($slika_url)) . '" target="_blank">
                        <img src="' . htmlspecialchars(trim($slika_url)) . '">
                    </a>
                </figure>';
            }
        }
    }
} else {
    print '<p>No images found in the database.</p>';
}

print '
    </section>
</div>
</body>
</html>';

mysqli_close($conn);
?>