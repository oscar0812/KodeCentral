<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Home</title>
    <meta name="description" content="Kode central home page. Talk about almost anything, but mostly programming.">
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
      <div class="ms-hero-page ms-hero-img-coffee ms-hero-bg-info mb-6">
        <div class="container">
          <div class="text-center">
            <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">Home</h1>
            <p class="lead lead-lg color-white text-center center-block mt-2 mb-4 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">Discover our projects and the
              <span class="color-warning">rigorous process</span> of creation. Our principles are creativity, design, experience and knowledge.</p>
            <a href="<?=$router->pathFor('user-login-form')?>" class="btn btn-raised btn-warning animated fadeInUp animation-delay-10">
              <i class="zmdi zmdi-accounts"></i> Become a member</a>
            <a href="<?=$router->pathFor('contact-us')?>" class="btn btn-raised btn-info animated fadeInUp animation-delay-10">
              <i class="zmdi zmdi-email"></i> Contact us</a>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-filter-list"></i>Filter List</h3>
              </div>
              <div class="card-body no-pb">
                <form class="form-horizontal">
                  <div class="form-group mt-1">
                    <div class="radio no-mb neg-top">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios0" value="option0" checked="" class="filter" data-filter="all"> Show All
                      </label>
                    </div>
                  </div>

                  <h4 class="no-m color-primary">Libraries</h4>
                  <div class="form-group mt-1">


                    <?php foreach($all_libraries as $library) { ?>
                    <div class="radio no-mb">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios<?=$library->getId()?>" value="option<?=$library->getId()?>" class="filter" data-filter=".library-<?=preg_replace('/\s+/', '-', strtolower($library->getName()))?>"> <?=$library->getName()?> </label>
                    </div>
                    <?php } ?>

                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-9" id="Container">
            <?php foreach ($posts as $post) { ?>
              <div class="card post-card mb-1 mix library-<?=preg_replace('/\s+/', '-', strtolower($post->getLibrary()->getName()))?> col-sm-12" data-url="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>">
                <table class="table table-responsive table-no-border vertical-center">
                  <tbody>
                    <tr>
                      <td class="d-none d-sm-block">
                        <img src="assets/img/default_pfp.png" class="avatar-50-50" alt="">
                      </td>
                      <td style="width: <?php if($user !=null) echo '60'; else echo '70';?>%">
                        <h4 class=""><?=$post->getTitle()?></h4>
                      </td>
                      <td style="width: 30%">
                        <span class="color-info"><?=$post->getPostedDate()->format('F d, Y')?></span>
                      </td>
                      <?php if(isset($user) && $user!= null) { ?>
                      <td style="width: 10%">
                        <button class="btn btn-warning child-click favorite" data-fav-url="<?=$router->pathFor('user-favorites')?>" data-post-link="<?=$post->getHyperlink()?>">
                          <i class="zmdi zmdi-star<?php if(!$user->hasPostInFavorites($post))echo "-outline";?> child-click"></i><div class="ripple-container"></div></button>
                      </td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- item -->
             <?php } ?>
           </div>
        </div>
      </div>
      <!-- container-fluid -->
      <?php require_once('templates/footer.php') ?>
    </div>
    <?php require_once('templates/slidebar.php')?>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/portfolio.js"></script>
    <script src="assets/js/component-snackbar.js"></script>
    <script type="text/javascript">

      $(function(){
        $('.post-card .favorite').on('click', function(){
          icon = $(this).find('.zmdi');
          url = $(this).data('fav-url');
          post = $(this).data('post-link')

          $.ajax({
            type: "POST",
            data: {
              post: post
            },
            url: url,
            dataType: "json",
            success: function(data) {

              if(!data['success'])
                return;

              snack_text = 'Added post to favorites!';
              if(data['status'] == 'removed'){
                icon.addClass('zmdi-star-outline');
                icon.removeClass('zmdi-star');

                snack_text = 'Removed post from favorites!'
              } else if(data['status'] == 'added'){
                icon.addClass('zmdi-star');
                icon.removeClass('zmdi-star-outline');
              }

              Snackbar.show({
                text: snack_text,
                actionText: 'View',
                onActionClick: function(element) {
                  window.location.href = url;
                }
              });

            }

          });

          return false;
        });
      });
    </script>
  </body>
</html>
