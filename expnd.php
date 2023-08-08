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

<div class="container mt-5">
    <?php if ($expandedURL): ?>
        <h3>Here is your Magnet URL!</h3>

        <div class="input-group">
            <textarea class="form-control small-monospace-text" id="magnetURLInput" rows="3" readonly><?php echo $expandedURL; ?></textarea>

            <button class="btn btn-primary" type="button" onclick="copyToClipboard('magnetURLInput')">
                Copy <i class="fas fa-copy ml-1"></i>
            </button>
        </div>


    <?php else: ?>
        <h3>Sorry, we couldn't find that URL!</h3>
    <?php endif; ?>
</div>







