<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Cental | About us</title>
    <meta name="description" content="About us">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
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
      <div class="ms-hero-page-override ms-hero-img-city ms-hero-bg-primary">
        <div class="container">
          <div class="text-center">
            <span class="ms-logo ms-logo-lg ms-logo-white center-block mb-2 mt-2 animated zoomInDown animation-delay-5">KC</span>
            <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">Kode
              <span>Central</span>
            </h1>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card card-hero animated slideInUp animation-delay-8 mb-6">
          <div class="card-body">
            <h2 class="color-primary">About Us</h2>
            <div class="row">
              <div class="col-lg-6 text-justify">
                <p class="dropcaps">We are a group of in-house software developers with a passion to help. Kodecentral is a project of <a href="https://aszend.com">Aszend Digital, LLC</a> (a Weslaco sofware development agency).</p>
                <p>Kodecentral was made by the lead developer of Aszend, Oscar, and is maintained with the help of <a href="<?=$router->pathFor('user-profile', ['username'=>'bit'])?>">Bit</a>. Kodecentral is made with the goal
                  of helping other developers grow as better programmers by examples, such as many dynamic programming problems, and even homework questions.</p>
              </div>
              <div class="col-lg-6 text-justify">
                <p>If you'd like to contribute to kodecentral make sure to create an account and to <a href="<?=$router->pathFor('contact-us')?>">contact us</a> requesting approval to post your knowledge on this website.</p>
                <p>If you have any other questions make sure to look at our <a href="<?=$router->pathFor('faq')?>">Frequently Asked Questions</a> page, and if you don't find a solution make sure you contact us to recieve help as soon as possible.
                You are also welcome to visit Aszend and request a beautiful website like this one.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container -->
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
  </body>
</html>
