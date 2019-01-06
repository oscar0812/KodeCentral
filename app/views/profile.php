<!DOCTYPE html>
<html lang="en">
<?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#333">
  <title>Kode Central | <?=$user->getUsername()?> | <?=$user->getBio()?>
  </title>
  <meta name="description" content="Profile for <?=$user->getUsername()?>">
  <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
  <!--[if lt IE 9]>
        <script src="<?=$home?>assets/js/html5shiv.min.js"></script>
        <script src="<?=$home?>assets/js/respond.min.js"></script>
    <![endif]-->

  <script type="text/javascript">
    function pfpError(image) {
      image.src = '../assets/img/default_pfp.png';
    }
  </script>

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
        <div class="col-lg-4">
          <div class="row">
            <div class="col-lg-12 col-md-6 order-md-1">
              <div class="card animated fadeInUp animation-delay-7">
                <div class="ms-hero-bg-primary ms-hero-img-coffee">
                  <?php if($user->isSuper()) { ?>
                  <h3 class="color-white index-1 text-center no-m pt-4">Status: <?=$user->getBadge()?></h3>
                  <?php } ?>
                  <div class="color-medium index-1 text-center np-m<?=$user->isSuper()?'':' pt-4'?>">@<?=$user->getUsername()?></div>
                  <img src="<?=$user->getPfp($home)?>" alt="..." class="img-avatar-circle pfp" onerror="pfpError(this);">
                </div>
                <div class="card-body pt-4 text-center">
                  <h3 class="color-primary">Bio</h3>
                  <p class="bio-text">
                    <?=$user->getBio()?>
                  </p>
                  <!--
                  <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                      <i class="zmdi zmdi-facebook"></i>
                    </a>
                  <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                      <i class="zmdi zmdi-twitter"></i>
                    </a>
                  <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                      <i class="zmdi zmdi-instagram"></i>
                    </a>
                  -->
                </div>
              </div>
            </div>
            <?php if(!$visiting) { ?>
            <div class="col-lg-12 col-md-12 order-md-3 order-lg-2">
              <button type="button" class="btn btn-warning btn-raised btn-block animated fadeInUp animation-delay-12" data-toggle="modal" data-target="#profile-modal">
                  <i class="zmdi zmdi-edit"> Edit Profile</i>
                </button>
              <a href="<?=$router->pathFor('user-logout')?>" class="btn btn-danger btn-raised btn-block animated fadeInUp animation-delay-12">
                  <i class="fa fa-sign-out"></i> Log Out</a>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-6 order-md-2 order-lg-3">
              <div class="card animated fadeInUp animation-delay-12">
                <div class="ms-hero-bg-royal ms-hero-img-mountain">
                  <h3 class="color-white index-1 text-center pb-4 pt-4">Recent Comments</h3>
                </div>
                <div class="card-body">
                    <div class="ms-footer-media">

                      <?php foreach ((clone $comments)->limit(3) as $comment) {
                        $post = $comment->getPost()?>

                        <!-- media block -->
                        <?php $path = $router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>
                        <div class="media">
                          <div class="media-left media-middle">
                            <a href="<?=$path?>">
                                <img class="media-object media-object-circle avatar-50-50" src="<?=$home?>assets/img/default_pfp.png" alt="..."> </a>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?=$path?>">
                                  <?=$post->getTitle()?></a>
                              </h4>
                            <div class="media-footer">
                              <p data-url="<?=$path?>"><?=$comment->getSummary()?></p><br>
                            </div>
                          </div>
                        </div>
                        <!-- /media block -->
                      <?php }?>

                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">

          <div class="row">
            <div class="col-sm-4">
              <div class="card card-info card-body overflow-hidden text-center">
                <h2 class="color-info"><?=$posts->count()?></h2>
                <i class="fa fa-4x fa-file-text color-info"></i>
                <p class="mt-2 no-mb lead small-caps color-info">Posts</p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card card-success card-body overflow-hidden text-center">
                <h2 class="color-success"><?=$favorites->count()?></h2>
                <i class="fa fa-4x fa-star color-success"></i>
                <p class="mt-2 no-mb lead small-caps color-success">times favorited</p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card card-royal card-body overflow-hidden text-center">
                <h2 class="color-royal"><?=$comments->count()?></h2>
                <i class="fa fa-4x fa-comments-o color-royal"></i>
                <p class="mt-2 no-mb lead small-caps color-royal">comments</p>
              </div>
            </div>
          </div>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">
                  <i class="zmdi zmdi-account-circle"></i> General Information</h3>
            </div>
            <table class="table table-no-border table-striped">
              <tr>
                <th>
                  <i class="zmdi zmdi-account mr-1 color-success"></i> User Name</th>
                <td>
                  <?=$user->getUsername()?>
                </td>
              </tr>
              <tr>
                <th>
                  <i class="zmdi zmdi-email mr-1 color-danger"></i> Email</th>
                <td>
                  <a href="mailto:<?=$user->getEmail()?>"><?=$user->getEmail()?></a>
                </td>
              </tr>
              <tr>
                <th>
                  <i class="zmdi zmdi-calendar mr-1 color-royal"></i> Member Since</th>
                <td>
                  <?=$user->getJoinDate()->format('m/d/Y')?>
                </td>
              </tr>
            </table>
          </div>

          <h2 class="color-primary text-center mt-4 mb-2">Activity</h2>
          <div class="row">
            <div class="col-lg-12">
              <ul class="ms-timeline">
                <?php foreach($posts as $post) {
                        $date = $post->getPostedDate()?>
                <li class="ms-timeline-item" data-url="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>">
                  <div class="ms-timeline-date">
                    <time class="timeline-time" datetime=""><?=$date->format('Y')?>
                        <span><?=$date->format('F')?></span>
                      </time>
                    <i class="ms-timeline-point bg-<?=$post->getBg()?>"></i>
                    <div class="card card-<?=$post->getBg()?>">
                      <div class="card-header">
                        <h3 class="card-title"><?=$post->getTitle()?></h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <p>
                              <?=$post->getSummary(300)?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                </li>
                <?php } ?>
                <li class="ms-timeline-item">
                  <div class="ms-timeline-date">
                    <time class="timeline-time" datetime=""><?=$user->getJoinDate()->format('Y')?>
                        <span><?=$user->getJoinDate()->format('F')?></span>
                      </time>
                    <i class="ms-timeline-point"></i>
                  </div>
                  <div class="card">
                    <div class="ms-hero-bg-primary ms-hero-img-coffee">
                      <h3 class="color-white index-1 text-center no-m pt-4">Status: <?=$user->getBadge()?></h3>
                      <div class="color-medium index-1 text-center np-m">@
                        <?=$user->getUsername()?>
                      </div>
                      <img src="<?=$user->getPfp($home)?>" alt="..." class="img-avatar-circle pfp" onerror="pfpError(this);"> </div>
                    <div class="card-body pt-4 text-center">
                      <h3 class="color-primary">Bio</h3>
                      <p class="bio-text">
                        <?=$user->getBio()?>
                      </p>
                      <!--
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                          <i class="zmdi zmdi-facebook"></i>
                        </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                          <i class="zmdi zmdi-twitter"></i>
                        </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                          <i class="zmdi zmdi-instagram"></i>
                        </a>
                      -->
                    </div>
                  </div>
                </li>
              </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container -->

      <!-- Modal -->
      <div class="modal" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg animated zoomIn animated-3x" role="document">
          <div class="modal-content">

            <form class="form-horizontal" autocomplete="off" method="post" action="<?=$router->pathFor('user-profile-info')?>" enctype="multipart/form-data" id="profile-form">
              <fieldset>
                <div class="modal-header">
                  <h3 class="modal-title color-primary" id="myModalLabel">Change profile settings</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="zmdi zmdi-close"></i></span></button>
                </div>
                <div class="modal-body container">
                  <div class="form-group row justify-content-start">
                    <div class="col-sm-12">
                      <input type="text" readonly="" class="form-control" placeholder="Upload profile picture...">
                      <input type="file" accept="image/*" name="pfpUpload">
                      <input type="hidden" name="file-text" value="">
                    </div>
                  </div>

                  <div class="form-group row justify-content-start">
                    <label for="textArea" class="col-lg-1 control-label">Bio</label>
                    <div class="col-lg-11">
                      <textarea class="form-control" rows="3" name="bio"><?=$user->getBio()?></textarea>
                      <span class="help-block">Something short and simple about you.</span>
                    </div>
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
    <?php require_once('templates/slidebar.php')?>
    <!-- ms-site-container -->
    <script src="<?=$home?>assets/js/plugins.min.js"></script>
    <script src="<?=$home?>assets/js/app.min.js"></script>

    <script src="<?=$home?>assets/js/component-snackbar.js"></script>
    <?php if(!$visiting) { ?>
    <script type="text/javascript">
      $(function() {
        $('#profile-form').on('submit', function(e) {
          // needed to check if user is also submitting a picture
          $('input[name="file-text"]').val($('input[name="pfpUpload"]').val());

          ajaxForm(e.target, function(data) {
            if (data['success']) {
              if (typeof data['path'] != 'undefined') {
                $('.pfp').attr('src', data['path'] + '?' + (new Date).getTime());
              }
              $('.bio-text').text(data['bio']);

              Snackbar.show({
                actionTextColor: '#00ff00',
                text: 'Profile information updated'
              });
            } else {
              Snackbar.show({
                actionTextColor: '#ff0000',
                text: data['msg']
              });
            }
          });
          return false;
        })
      })
    </script>
    <?php } ?>
</body>

</html>
