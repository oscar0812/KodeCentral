<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Search</title>
    <meta name="description" content="Material Style Theme">
    <link rel="shortcut icon" href="assets/img/favicon.png?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/css/preload.min.css">
    <link rel="stylesheet" href="assets/css/plugins.min.css">
    <link rel="stylesheet" href="assets/css/style.blue-600.min.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
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
      <div class="ms-hero-page-override ms-hero-img-city ms-hero-bg-royal">
        <div class="container">
          <div class="text-center">
            <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">Search post</span>
            </h1>
            <form class="mw-500 center-block animated fadeInUp">
              <input type="text" placeholder="Enter keyword here to search titles and main text.." class="form-control color-white">
              <button type="button" class="btn btn-raised btn-primary btn-block">
                <i class="zmdi zmdi-search"></i> Search</button>
            </form>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card card-hero animated slideInUp animation-delay-8 mb-6">
          <div class="card-body">
            <h2 class="right-line right-line-white">Results</h2>
            <!--results here -->
          </div>
        </div>
      </div>
      <!-- /container -->
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
  </body>
</html>
