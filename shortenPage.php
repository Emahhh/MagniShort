<?php
require_once 'shortenedDB.php';

function isValidMagnetUrl($magnetUrl) : bool {
    return preg_match('/magnet:[\?xt\=\w\:\&\;\+\%\.]+/', $magnetUrl);
}

$shortener = new ShortenedDB();

?>

  <div class="starter-template text-center py-5 px-3">
    <h1>Welcome to MagniShort!</h1>
    <p class="lead">Shorten your Magnet URL here!</p>
  </div>



    <?php
    $magnetUrl = null;
    $shortenedCode = null;
    $myError = null;

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['magneturl'])) {
        $magnetUrl = $_GET['magneturl'];

        if (!$magnetUrl or !isValidMagnetUrl($magnetUrl)) {
            $myError = "Please enter a valid magnet URL!";
        }else {
            $myError = null;
            $shortenedCode = $shortener->shortenMagnetURL($magnetUrl);
        }
    }

    ?>



    <?php if ($shortenedCode === null) : ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
            <div class="d-flex mb-3 shadow-lg rounded-pill input-group-lg">
                <label for="magneturl" class="form-label visually-hidden">Magnet URL</label>
                <input type="url" name="magneturl" id="magneturl" class="form-control rounded-pill-start rounded-end-0" placeholder="Paste your magnet URL here! magnet:?xt=urn:btih:..." aria-label="Magnet URL" aria-describedby="button-addon2" required autocomplete="off">
                <button type="submit" class="btn btn-primary rounded-start-0 rounded-pill-end text-with-shadow">
                    Shorten!
                    <i class="fa fa-link"></i>
                </button>
            </div>

        </form>
    <?php endif; ?>


<?php
if ($shortenedCode !== null) {
    $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $currentURLWithoutQuery = strtok($currentURL, '?'); // Remove query string
    $shortenedURL = $currentURLWithoutQuery . '?s=' . $shortenedCode;
?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Here is your new short URL!</h4>
        <p class="mb-0">You can now copy this URL and share it with your friends!</p>
        <div class="input-group mt-3 input-group-lg">
            <input type="url" class="form-control-lg" id="shortenedURLInput" value="<?= $shortenedURL ?>" readonly>
            <button class="btn btn-primary" type="button" id="copyShortBtn" onclick="copyAndFeedback('<?= $shortenedURL ?>', 'copyShortBtn')">
                Copy <i class="fas fa-copy ml-1"></i>
            </button>
        </div>
    </div>

<?php } ?>

    <?php if (
        $myError !== null
        or ($magnetUrl !== null and $shortenedCode === null)
    ){ ?>
        <div class="alert alert-danger" role="alert">
            <?= "Error! " . $myError ?>
        </div>
    <?php } ?>

