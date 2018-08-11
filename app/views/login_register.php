<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Login & Register</title>
    <meta name="description" content="Log in or register! It's completely free!">
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
    <div class="bg-full-page ms-hero-bg-dark ms-hero-img-airplane back-fixed">
      <div class="mw-500 absolute-center">
        <div class="card color-dark shadow-6dp animated fadeIn animation-delay-7">
          <div class="ms-hero-bg-primary ms-hero-img-mountain">
            <h2 class="text-center no-m pt-4 pb-4 color-white index-1">Login Form</h2>
          </div>
          <ul class="nav nav-tabs nav-tabs-full nav-tabs-3 nav-tabs-transparent indicator-primary" role="tablist">
            <li class="nav-item" role="presentation">
              <a href="#ms-login-tab" aria-controls="ms-login-tab" role="tab" data-toggle="tab" class="nav-link withoutripple active">
                <i class="zmdi zmdi-account"></i> Login</a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="#ms-register-tab" aria-controls="ms-register-tab" role="tab" data-toggle="tab" class="nav-link withoutripple">
                <i class="zmdi zmdi-account-add"></i> Register</a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="#ms-recovery-tab" aria-controls="ms-recovery-tab" role="tab" data-toggle="tab" class="nav-link withoutripple">
                <i class="zmdi zmdi-key"></i> Recovery</a>
            </li>
          </ul>
          <div class="card-body">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade active show" id="ms-login-tab">
                <form id="login-form" action="<?=$router->pathFor('user-credentials')?>" method="post">
                  <fieldset>
                    <div class="form-group label-floating">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="zmdi zmdi-account"></i>
                        </span>
                        <label class="control-label" for="ms-form-user">Username</label>
                        <input type="text" id="ms-form-user" name="Login[Username]" class="form-control"> </div>
                    </div>
                    <div class="form-group label-floating">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="zmdi zmdi-lock"></i>
                        </span>
                        <label class="control-label" for="ms-form-pass">Password</label>
                        <input type="password" id="ms-form-pass" name="Login[Password]" class="form-control"> </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-6">
                        <label id="login-label" class="invisible text-danger">Incorrect Email or Password</label>
                      </div>
                      <div class="col-1"></div>
                      <div class="col-5">
                        <button class="btn btn-raised btn-primary pull-right">Login</button>
                      </div>
                    </div>
                  </fieldset>
                </form>
                <div class="text-center">
                  <h3>Login with</h3>
                  <a href="javascript:void(0)" class="wave-effect-light btn btn-raised btn-facebook">
                    <i class="zmdi zmdi-facebook"></i> Facebook</a>
                  <a href="javascript:void(0)" class="wave-effect-light btn btn-raised btn-twitter">
                    <i class="zmdi zmdi-twitter"></i> Twitter</a>
                  <a href="javascript:void(0)" class="wave-effect-light btn btn-raised btn-google">
                    <i class="zmdi zmdi-google"></i> Google</a>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="ms-register-tab">
                <form id="register-form" action="<?=$router->pathFor('user-credentials')?>" method="post">
                  <fieldset>
                    <div class="form-group label-floating">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="zmdi zmdi-account"></i>
                        </span>
                        <label class="control-label" for="ms-form-user-r">Username</label>
                        <input type="text" id="ms-form-user-r" name="Register[Username]" class="form-control"> </div>
                    </div>
                    <div class="form-group label-floating">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="zmdi zmdi-email"></i>
                        </span>
                        <label class="control-label" for="ms-form-email-r">Email</label>
                        <input type="email" id="ms-form-email-r" name="Register[Email]" class="form-control"> </div>
                    </div>
                    <div class="form-group label-floating">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="zmdi zmdi-lock"></i>
                        </span>
                        <label class="control-label" for="ms-form-pass-r">Password</label>
                        <input type="password" id="ms-form-pass-r" name="Register[Password]" class="form-control"> </div>
                    </div>
                    <button class="btn btn-raised btn-block btn-primary">Register Now</button>
                    <label id="register-label" class="invisible">Email is already in use</label>
                  </fieldset>
                </form>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="ms-recovery-tab">
                <form id="forgot-form" action="<?=$router->pathFor('user-credentials')?>" method="post">
                <fieldset>
                  <div class="form-group label-floating">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="zmdi zmdi-account"></i>
                      </span>
                      <label class="control-label" for="ms-form-user-recovery">Username</label>
                      <input type="text" id="ms-form-user-recovery" name="Forgot[Username]" class="form-control"> </div>
                  </div>
                  <div class="form-group label-floating">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="zmdi zmdi-email"></i>
                      </span>
                      <label class="control-label" for="ms-form-email-recovery">Email</label>
                      <input type="email" id="ms-form-email-recovery" name="Forgot[Email]" class="form-control"> </div>
                  </div>
                  <button class="btn btn-raised btn-block btn-primary">Send Password</button>
                </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center animated fadeInUp animation-delay-7">
          <a href="<?=$router->pathFor('home')?>" class="btn btn-white">
            <i class="zmdi zmdi-home"></i> Go Home</a>
        </div>
      </div>
    </div>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/login_register.js"></script>
  </body>
</html>
