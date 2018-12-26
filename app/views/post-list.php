<!DOCTYPE html>
<html lang="en">
  <?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | <?=$title?></title>
    <meta name="description" content="All libary posts in one place">
    <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
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
      <div class="container">
        <h1 class="right-line mb-4"><?=$title?> (<?=$posts->count()?>)</h1>
        <div class="row">
          <div class="col-sm-12">
            <?php foreach ($posts as $post) { ?>
              <div class="card post-card mb-1 mix col-sm-12" data-url="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>">
                <table class="table table-responsive table-no-border vertical-center">
                  <tbody>
                    <tr>
                      <td></td>
                      <td style="width: 70%">
                        <h4 class=""><?=$post->getTitle()?></h4>
                      </td>
                      <td style="width: 30%">
                        <span class="color-info"><?=$post->getPostedDate()->format('F d, Y')?></span>
                      </td>

                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- item -->
             <?php } ?>
          </div>
          <!--
          <div class="col-md-3">
            <div class="card card-info">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Info</div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li>
                    <strong>Posts: </strong> <span id="post-count"><?=$posts->count()?></span></li>
                </ul>
                <?php if(isset($user) && $user!= null && $user->isSuper()) { ?>
                <a href="<?=$router->pathFor('create-post')?>" class="btn btn-raised btn-info btn-block btn-raised mt-2 no-mb">
                  <i class="zmdi zmdi-plus"></i> New</a>
                <?php } ?>
              </div>

            </div>
          </div>
        -->
        </div>
      </div>
      <!-- container -->
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="<?=$home?>assets/js/plugins.min.js"></script>
    <script src="<?=$home?>assets/js/app.min.js"></script>
    <?php if(isset($favorites) && $favorites == true) { ?>
    <script type="text/javascript">
    $('.post-card .favorite').on('click', function(){
      icon = $(this).find('.zmdi');
      url = $(this).data('fav-url');
      post = $(this).data('post-link');

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
          if(data['status'] == 'removed'){
            icon.parents('.post-card').remove();
            // subtract 1 from total post count
            $('#post-count').text(parseInt($('#post-count').text())-1);
          }
        }
      });

      return false;
    });
    </script>
    <?php } ?>
  </body>
</html>
