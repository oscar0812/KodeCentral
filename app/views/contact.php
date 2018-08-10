<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Contact</title>
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
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-primary animated fadeInUp animation-delay-7">
              <div class="ms-hero-bg-primary ms-hero-img-mountain">
                <h2 class="text-center no-m pt-4 pb-4 color-white index-1">Contact</h2>
                <h4 class="text-center no-m pt-0 pb-4 color-white index-1">Report a problem with the website or request a post (even from chegg)</h4>
              </div>
              <div class="card-body">
                <form class="form-horizontal" id="contact-form" method="post" action="">
                  <fieldset class="container">
                    <div class="form-group row">
                      <label for="inputEmail" autocomplete="false" class="col-lg-2 control-label">Email</label>
                      <div class="col-lg-9">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email"> </div>
                    </div>
                    <div class="form-group row">
                      <label for="textArea" class="col-lg-2 control-label">Message</label>
                      <div class="col-lg-9">
                        <textarea class="form-control" rows="3" id="textArea" placeholder="Your message..." name="message"></textarea>
                      </div>
                    </div>
                    <div class="form-group row justify-content-end">
                      <div class="col-lg-10">
                        <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                      </div>
                    </div>
                  </fieldset>
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
    <script src="<?=$home?>assets/js/component-snackbar.js"></script>
    <script type="text/javascript">
    $(function(){
      $('#contact-form').on('submit', function(e){
        Snackbar.show({
          actionTextColor: '#ffff00',
          text: 'Sending email...'
        });
        ajaxForm(e.target, function(data){
          color = '#ff0000';
          if(data['success']){
            color = '#00ff00';
          }

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
