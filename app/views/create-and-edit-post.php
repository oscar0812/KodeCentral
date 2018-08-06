<!DOCTYPE html>
<html lang="en">
<?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>
<?php (isset($post) && $post!= null)?$editing = true:$editing = false; ?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#333">
  <title>Kode Central</title>
  <meta name="description" content="Kode Central, a place for programmers">
  <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/katex.min.css" />
  <link rel="stylesheet" href="<?=$home?>assets/css/monokai-sublime.min.css" />
  <link rel="stylesheet" href="<?=$home?>assets/css/quill.snow.css" />
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
          <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5"><?=$editing?"Editing":"New"?> Post</h1>
          <p class="lead lead-lg color-light text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">
            <?=$editing?$post->getTitle():"Create a new blog post"?>
          </p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="card card-hero animated fadeInUp animation-delay-7">
        <div class="card-body">
          <form id="create-form" class="form-horizontal" action "" method="post">
            <fieldset class="container">
              <div class="form-group label-floating">
                <label class="control-label" for="title">Title</label>
                <input class="form-control" id="title" type="text" value="<?=$editing?$post->getTitle():" "?>">
                <p class="help-block">Short and simple</p>
              </div>
              <div class="form-group">
                <span>Categories</span>
                <select id="categories-select" multiple="" class="selectpicker form-control" data-dropup-auto="false">
                    <?php foreach ($all_categories as $ac) {
                      $selected = false;

                      foreach ($post_categories as $pc) {
                        if ($ac->getId() == $pc->getId()) {
                          $selected = true;
                        }
                      } ?>

                        <option <?=$selected?"selected":""?>>
                        <?=$ac->getName()?></option>
                      <?php
                    } ?>
                  </select>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <span>Library</span>
                    <div class="input-group">
                      <?php $c_lib = $editing?$post->getLibrary():null;?>
                      <select id="library-select" class="selectpicker form-control" data-dropup-auto="false" data-posts-url="<?=$router->pathFor('ajax-lib-posts')?>">
                          <?php
                          foreach ($all_libraries as $lib) {
                            $selected = false;
                            if($c_lib != null && $c_lib == $lib){
                              $selected = true;
                            } ?>
                            <option value="<?=$lib->getName()?>" <?=$selected?"selected":""?>><?=$lib->getName()?></option>
                            <?php
                          } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <span>Position</span>
                    <div class="input-group">
                      <?php $c_lib = $editing?$post->getLibrary():null;?>

                      <select id="position-select" class="selectpicker form-control" data-dropup-auto="false">

                      </select>

                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#library-modal">New</button>
                      </span>
                    </div>
                  </div>
                </div>
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
                        <button class="ql-formula"></button>
                      </span>
                    <span class="ql-formats">
                        <button class="ql-clean"></button>
                      </span>
                  </div>
                  <div id="editor-container"></div>
                  <div class="invisible" id="preload-content">
                    <?=$editing?$post->getText():""?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-lg-10">
                  <?php if(!$editing) { ?>
                  <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                  <?php } ?>
                  <button <?php if(!$editing) { ?>id="save-button" <?php } ?> type="submit" class="btn btn-raised btn-success">Save</button>
                  <?php if ($editing) { ?>
                  <a href="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>" class="btn btn-success"> view </a>
                  <?php } ?>
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$user->getUsername()])?>" class="btn btn-danger"> cancel </a>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-lg-10">
                  <p class="invisible" id="submit-response">Hello</p>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>

    <div class="modal" id="library-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg animated zoomIn animated-3x" role="document">
        <div class="modal-content">

          <form class="form-horizontal" autocomplete="off" method="post" action="<?=$router->pathFor('create-lib')?>" enctype="multipart/form-data" id="library-form">
            <fieldset>
              <div class="modal-header">
                <h3 class="modal-title color-primary" id="myModalLabel">Create new library</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="zmdi zmdi-close"></i></span></button>
              </div>
              <div class="modal-body container">

                <div class="form-group label-floating">
                  <label class="control-label" for="title">Name</label>
                  <input class="form-control" type="text" name="lib-name">
                  <p class="help-block">Libraries are meant to group posts together (for tutorials and such)</p>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
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

  <script src="<?=$home?>assets/js/js-cookie.js"></script>

  <script src="<?=$home?>assets/js/katex.min.js"></script>
  <script src="<?=$home?>assets/js/highlight.min.js"></script>
  <script src="<?=$home?>assets/js/quill.min.js"></script>
  <script src="<?=$home?>assets/js/component-snackbar.js"></script>
  <script src="<?=$home?>assets/js/create-and-edit-post.js"></script>

</body>

</html>
