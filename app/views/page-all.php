<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | All pages</title>
    <meta name="description" content="Kode Central, a place for programmers">
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
      <div class="material-background"></div>
      <div class="container container-full">
        <div class="card animated slideInUp animation-delay-8 mb-6">
          <div class="card-body-big">
            <h2 class="right-line right-line-white">All pages</h2>
            <div class="row">
              <div class="col-md-6">
                <h3 class="color-primary mt-4">General &amp; Help</h3>
                <ul class="list-line">
                  <li>
                    <a href="<?=$router->pathFor('home')?>">Home</a>
                  </li>
                  <li>
                    <a href="<?=$router->pathFor('about-us')?>">About Us</a>
                  </li>
                  <li>
                    <a href="<?=$router->pathFor('contact-us')?>">Contact</a>
                  </li>
                  <li>
                    <a href="<?=$router->pathFor('faq')?>">FAQ</a>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <h3 class="color-primary mt-4">Other</h3>
                <ul class="list-line">
                  <?php if($user == null) { ?>
                  <li>
                    <li>
                      <a href="<?=$router->pathFor('user-login-form')?>">Login</a>
                    </li>
                  </li>
                  <?php } else { ?>
                    <li>
                      <a href="<?=$router->pathFor('user-login-form')?>">Profile</a>
                    </li>
                    <?php if($user->isSuper()) { ?>
                    <li>
                      <a href="<?=$router->pathFor('create-post')?>">Create post</a>
                    </li>
                  <?php }
                      }?>

                </ul>
              </div>
            </div>
            <!-- row -->
          </div>
        </div>
      </div>
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
  </body>
</html>
