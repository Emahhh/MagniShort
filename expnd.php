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

        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">Here is your Magnet URL!</h3>
                <div class="input-group mb-3">
                    <label for="magnetURLInput" class="form-label visually-hidden">Magnet URL</label>
                    <a class="small-monospace-text link-dark link-underline link-underline-opacity-25 text-break mb-0 link-underline-opacity-75-hover" href="<?= $expandedURL ?>">
                        <?php echo $expandedURL; ?>
                    </a>
                </div>

                <a href="<?php echo $expandedURL; ?>" target="_blank" class="btn btn-primary m-3 p-2">
                    Download using your torrent client
                    <i class="fa fa-download"></i>
                </a>

                <button class="btn btn-secondary m-3 p-2" type="button"
                        onclick="copyToClipboard('<?php echo $expandedURL; ?>')">
                    Copy to clipboard
                    <i class="fa fa-clipboard"></i>
                </button>
                <a class="link-underline link-underline-opacity-50 p-2 m-3 align-content-end" href="#"
                 data-bs-toggle="modal" data-bs-target="#downloadModal">
                    Help, I don't have a torrent client!
                </a>

            </div>
        </div>


    <?php else: ?>
        <h3>Sorry, we couldn't find that URL!</h3>
    <?php endif; ?>
</div>



<!-- Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelTitleId"> Downloading a torrent file using a torrent client</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
                <p>
                To download a torrent file, you'll need a torrent client like Transmission. Install Transmission on your PC from their website at
                <a href="https://transmissionbt.com/download" target="_blank">https://transmissionbt.com/download</a>. <br>
                After installing, you'll be able to open magnet links from your browser and download the torrent file.
                </p>
            </div>

        </div>
    </div>
</div>



