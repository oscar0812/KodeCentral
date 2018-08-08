<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | FAQ</title>
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
          <div class="col-xl-8 col-lg-7">
            <div class="card">
              <div class="ms-hero-bg-primary ms-hero-img-mountain">
                <h3 class="color-white index-1 text-center pb-4 pt-4 no-mb">Frequently Asked Questions</h3>
              </div>
              <div class="ms-collapse no-margin" id="accordion12" role="tablist" aria-multiselectable="true">
                <div class="mb-0 card card-primary">
                  <div class="card-header" role="tab" id="headingOne12">
                    <h4 class="card-title ms-rotate-icon">
                      <a class="withripple" role="button" data-toggle="collapse" href="#collapseOne12" aria-expanded="trie" aria-controls="collapseOne12">
                        <i class="zmdi zmdi-attachment-alt"></i> What is a library? </a>
                    </h4>
                  </div>
                  <!-- take off "show" class to no open on load-->
                  <div id="collapseOne12" class="card-collapse collapse show" role="tabpanel" aria-labelledby="headingOne12" data-parent="#accordion12">
                    <div class="card-body">
                      <p>A library is a collection of posts which purpose is to make posts easier to navigate and increase the user experience.
                      Libraries are useful when making walk-throughs, tutorials, or just arranging similar posts together.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-5">
            <div class="card">
              <div class="ms-hero-bg-primary ms-hero-img-mountain">
                <h3 class="color-white index-1 text-center pb-4 pt-4 no-mb">Contact Us</h3>
              </div>
              <div class="card-body">
                <h3 class="color-primary">You have more questions?</h3>
                <form class="">
                  <div class="form-group label-floating">
                    <label for="inputName" class="control-label">Name</label>
                    <input type="text" class="form-control" id="inputName"> </div>
                  <div class="form-group label-floating">
                    <label for="inputEmail" class="control-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail"> </div>
                  <div class="form-group label-floating">
                    <label for="inputSubject" class="control-label">Subject</label>
                    <input type="text" class="form-control" id="inputSubject"> </div>
                  <div class="form-group label-floating">
                    <label for="textArea" class="control-label">Message</label>
                    <textarea class="form-control" rows="5" id="textArea"></textarea>
                  </div>
                  <div class="form-group text-right">
                    <button type="button" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                  </div>
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
  </body>
</html>
