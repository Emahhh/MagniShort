<!-- Expands the shortened URL to the original magnet URL, displaying it in a user-friendly way. -->
<?php

$shortCode = $_GET['s'] ?? null;
if (!$shortCode) {
    header('Location: /');
    exit;
}

require_once 'ShortenedDB.php';

$myShortenedDB = new ShortenedDB();

$expandedURL = $myShortenedDB->getMagnetFromShort($shortCode);
?>

<?php if ($expandedURL):?>
<h3> Here is your Magnet URL!</h3>
<pre>
    <?= $expandedURL   ?>
</pre>
<?php else: ?>
    <h3>Sorry, we couldn't find that URL!</h3>
<?php endif; ?>



