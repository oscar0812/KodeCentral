<!DOCTYPE html>
<html lang="en">
  <?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Material Style</title>
    <meta name="description" content="Material Style Theme">
    <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.png?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/plugins/quill/css/katex.min.css" />
    <link rel="stylesheet" href="<?=$home?>assets/plugins/quill/css/monokai-sublime.min.css" />
    <link rel="stylesheet" href="<?=$home?>assets/plugins/quill/css/quill.snow.css" />
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
      <div class="ms-hero-page-override ms-hero-img-team ms-hero-bg-primary">
        <div class="container">
          <div class="text-center">
            <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">New Post</h1>
            <p class="lead lead-lg color-light text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">Create a new blog post</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card card-hero animated fadeInUp animation-delay-7">
          <div class="card-body">
            <form class="form-horizontal">
              <fieldset class="container">
                <div class="form-group label-floating">
                  <label class="control-label" for="focusedInput2">Title</label>
                  <input class="form-control" id="focusedInput2" type="text">
                  <p class="help-block">Short and simple</p>
                </div>
                <div class="form-group label-floating">
                  <label class="control-label" for="focusedInput2">Summary</label>
                  <input class="form-control" id="focusedInput2" type="text">
                  <p class="help-block">What are you going to talk about?</p>
                </div>

                <div class="form-group">
                  <div id="standalone-container">
                    <div id="toolbar-container">
                      <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                      </span>
                      <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                        <button class="ql-formula"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-clean"></button>
                      </span>
                    </div>
                    <div id="editor-container"></div>
                  </div>
                </div>

                <div class="form-group row">
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

      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="<?=$home?>assets/js/plugins.min.js"></script>
    <script src="<?=$home?>assets/js/app.min.js"></script>

    <script src="<?=$home?>assets/plugins/quill/js/katex.min.js"></script>

    <script src="<?=$home?>assets/plugins/quill/js/highlight.min.js"></script>

    <script src="<?=$home?>assets/plugins/quill/js/quill.min.js"></script>

    <script>
      var quill = new Quill('#editor-container', {
        modules: {
          formula: true,
          syntax: true,
          toolbar: '#toolbar-container'
        },
        placeholder: 'Write your mind off...',
        theme: 'snow'
      });
    </script>
  </body>
</html>
