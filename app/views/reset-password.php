<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Reset your password</title>
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
      <div class="ms-hero-page-override ms-hero-img-city ms-hero-bg-dark-light">
        <div class="container">

        </div>
      </div>
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col-lg-6">
            <div class="card card-hero card-primary animated fadeInUp animation-delay-7">
              <div class="card-body">
                <h1 class="color-primary text-center">Reset your password</h1>
                <form class="form-horizontal" id="reset-form" action="" method="post">
                  <fieldset>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-md-3 control-label">Email</label>
                      <div class="col-md-9">
                        <input type="email" class="form-control" value="<?=$user->getEmail()?>" disabled> </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputPassword" class="col-md-3 control-label">New password</label>
                      <div class="col-md-9">
                        <input type="password" name="password" class="form-control" placeholder="Password"> </div>
                    </div>
                  </fieldset>
                  <button class="btn btn-raised btn-primary btn-block">Reset
                    <i class="zmdi zmdi-lock no-mr ml-1"></i>
                  </button>
                </form>
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
    <script src="assets/js/component-snackbar.js"></script>
    <script type="text/javascript">
      $(function(){
        $('#reset-form').on('submit', function(e){
          ajaxForm(e.target, function(data) {
            color = data['success']?'#00ff00':'#ff0000';
            Snackbar.show({
              actionTextColor: color,
              text: data['msg']
            });
          });
          return false;
        })
      });
    </script>
  </body>
</html>
