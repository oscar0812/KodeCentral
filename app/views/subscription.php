<!DOCTYPE html>
<html lang="en">
  <?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Subscription</title>
    <meta name="description" content="subcription">
    <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
    <!--[if lt IE 9]>
        <script src="<?=$home?>assets/js/html5shiv.min.js"></script>
        <script src="<?=$home?>assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="ms-preload" class="ms-preload">
      <div id="status">
        <div class="spinner">
          <div class="dot1"></div>
          <div class="dot2"></div>
        </div>
      </div>
    </div>
    <div class="ms-site-container">
      <?php require_once('templates/navbar.php')?>
      <div class="container">
        <h1 class="right-line mb-4"><?=$title?></h1>
        <div class="row">
          <div class="col-sm-12">
            <h3><?=$text?></h3>
          </div>

        </div>
      </div>
      <!-- container -->
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="<?=$home?>assets/js/plugins.min.js"></script>
    <script src="<?=$home?>assets/js/app.min.js"></script>
  </body>
</html>
