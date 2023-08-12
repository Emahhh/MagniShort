<!-- this template contains a page with a navbar and a footer.
The main content of the page is in the middle of the template.
The main content is loaded using a REQUIRE o different php file based on the value of $page. -->

<?php
 require_once __DIR__ . '/config.php';
 $config = new config();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>MagniShort</title>



    <!-- Bootstrap core CSS -->
    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="myStyle.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="">
    <meta name="theme-color" content="#7952b3">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/49599c00f1.js" crossorigin="anonymous"></script>



</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top p-4">
    <div class="container-fluid">
        <a class="navbar-brand text-with-shadow"
           href="<?= $config->home ?>"
        >
            MagniShort
            <i class="fa-solid fa-magnet fa-lg"></i>
        </a>


        <!-- link to current page, but without ?queries -->
        <a class=" btn btn-outline-light shadow p-2" type="button"
                href="<?= $config->home ?>"
        >
            Shorten a new URL
            <i class="fas fa-plus-circle p-1"></i>
        </a>

    </div>

</nav>

<main class="container m-5">
    <br>
    <br>

    <?php
        // print all the values in the $_GET array
        // echo "<pre>" . var_export($_GET, true) . "</pre>";

        if (isset($_GET['s'])) { // if the user has provided a shortened URL to be expanded, open the expand page
            require __DIR__ . '/expnd.php';
        } else { // if no shortened URL, give the user the option to shorten one
            require __DIR__ . '/shortenPage.php';
        }
    ?>
</main><!-- /.container -->

    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


    <script>
        async function copyToClipboard(txt){
            try {
                await navigator.clipboard.writeText(txt);
                console.log('Content copied to clipboard');
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }

        async function copyAndFeedback(txt, btnID){
            let btn = document.getElementById(btnID);
            await copyToClipboard(txt);

            let originalText = btn.innerHTML;
            btn.innerHTML = "Copied!";

            setTimeout(function(){
                btn.innerHTML = originalText;
            }, 2000);
        }
    </script>

  </body>
</html>