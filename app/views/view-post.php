<!DOCTYPE html>
<html lang="en">
<?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#333">
  <title><?=$post->getLibrary()->getName()?> | <?=$post->getTitle()?>
  </title>
  <meta name="description" content="<?=$post->getSummary(300)?>">
  <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
  <link rel="stylesheet" href="<?=$home?>assets/css/monokai-sublime.min.css">
  <!--[if lt IE 9]>
        <script src="<?=$home?>assets/js/html5shiv.min.js"></script>
        <script src="<?=$home?>assets/js/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
      function pfpError(image) {
        image.src = '/assets/img/default_pfp.png';
      }
    </script>
</head>

<body data-hyperlink="<?=$post->getHyperlink()?>" data-title="<?=$post->getTitle()?>">
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
        <div class="col-lg-8">
          <div class="card animated fadeInLeftTiny animation-delay-5">
            <div class="card-body card-body-big">
              <h1 class="no-mt"><?=$post->getTitle()?></h1>

              <div class="mb-4" id="user-info">
                <?php $username = $post->getPostedByUser()->getUsername();?>
                <a href="<?=$router->pathFor('user-profile', ['username'=>$username])?>" class="btn-circle mr-2">
                    <img src="<?=$post->getPostedByUser()->getPfp($home)?>" alt="..." class="img-circle mr-1 avatar-50-50">
                    <?=$post->getPostedByUser()->getBadge()?>
                  </a> by
                <a href="<?=$router->pathFor('user-profile', ['username'=>$username])?>">
                  <?=$post->getPostedByUser() == $user?$username." (You)":$username?>
                </a> in

                <?php $lib_name = $post->getLibrary()->getName()?>
                <a href="<?=$router->pathFor('library', ['name'=>$lib_name])?>" class="ms-tag ms-tag-info">
                  <?=$lib_name?>
                </a>

                <span class="ml-1 d-none d-sm-inline">
                    <i class="zmdi zmdi-time mr-05 color-info"></i>
                    <span class="color-medium-dark"><?=$post->getPostedDate()->format('F d, Y')?></span>
                </span>
                <?php if($user!= null && $post->getPostedByUser() == $user) { ?>
                <span class="ml-1">
                    <a href="<?=$router->pathFor('edit-post', ['hyperlink'=>$post->getHyperlink()])?>">
                      <i class="fa fa-pencil"> Edit</i>
                    </a>
                  <?php } ?>
                  </span>
              </div>
              <!-- post text here -->
              <div id="post-text">
                <?=$post->getText()?>
              </div>
              <!-- post text ends here -->
            </div>
          </div>
          <nav aria-label="...">
            <ul class="pager d-flex justify-content-between">
              <?php if($prev != null) { ?>
              <li class="page-item" data-toggle="tooltip" data-placement="top" title="<?=$prev->getTitle()?>">
                <a class="page-link" href="<?=$router->pathFor('view-post', ['hyperlink'=>$prev->getHyperlink()])?>">
                              <span aria-hidden="true">«</span> Previous</a>
              </li>
            <?php } else { ?>

              <li class="page-item" style="visibility: hidden"></li>

            <?php } if($next != null ) { ?>
              <li class="page-item" data-toggle="tooltip" data-placement="top" title="<?=$next->getTitle()?>">
                <a class="page-link" href="<?=$router->pathFor('view-post', ['hyperlink'=>$next->getHyperlink()])?>">Next
                              <span aria-hidden="true">»</span>
                            </a>
              </li>
            <?php } else { ?>

              <li class="page-item" style="visibility: hidden"></li>

            <?php } ?>
            </ul>
          </nav>

          <h2 class="right-line no-mt">Comments (<span id="comment-number"><?=$comments->count()?></span>)
              <?php if($comments->count() > 0) { ?>
              <a href="#" id="show-hide-comments" class="color-info"><i class="zmdi zmdi-eye-off"></i></a>
              <?php }?>
            </h2>

          <div class="card animated fadeInLeftTiny animation-delay-5">
            <div class="card-body" id="comment-body">

              <?php if(isset($user) && $user!= null) { ?>
              <div class="invisible" id="comment-template">
                <div class="ms-icon-feature-icon">
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$user->getUsername()])?>" class="btn-circle mr-2">
                      <img src="<?=$user->getPfp($home)?>" alt="..." class="img-circle mr-1 avatar-50-50">
                      <?=$user->getBadge()?>
                    </a>
                </div>
                <div class="ms-icon-feature-content">
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$user->getUsername()])?>"><?=$user->getUsername()?> (You)</a>
                  <p>Text</p>
                </div>
              </div>
              <?php }?>

              <?php foreach ($comments as $comment) { ?>
              <div class="ms-icon-feature">
                <div class="ms-icon-feature-icon">
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$comment->getUser()->getUsername()])?>" class="btn-circle mr-2">
                        <img src="<?=$comment->getUser()->getPfp($home)?>" alt="..." class="img-circle mr-1 avatar-50-50">
                        <?=$comment->getUser()->getBadge()?>
                      </a>
                </div>
                <div class="ms-icon-feature-content">
                  <?php $username = $comment->getUser()->getUsername();?>
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$username])?>">
                    <?=$username?>
                      <?php if($comment->getUser() == $user) echo " (You)"?>
                  </a>
                  <p>
                    <?=$comment->getText()?>
                  </p>
                </div>
              </div>
              <?php }?>

              <?php if($user == null) { ?>
              <a href="<?=$router->pathFor('user-login-form')?>" class="btn btn-block btn-md btn-raised btn-primary">Sign in to post a comment</a>
              <?php } else { ?>
              <form action="<?=$router->pathFor('post-comment', ['hyperlink'=>$post->getHyperlink()])?>" method="POST" id="comment-form">
                <div class="form-group row justify-content-end">
                  <textarea name="text" class="form-control" rows="2" placeholder="Your comment here.."></textarea>
                  <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                </div>
              </form>
              <?php }?>

            </div>
          </div>

        </div>
        <div class="col-lg-4 d-none d-lg-block">
          <div class="card card-primary animated fadeInUp animation-delay-7">
            <div class="card-header">
              <h3 class="card-title">
                  <i class="zmdi zmdi-apps"></i> Navigation
                </h3>
            </div>
            <div class="card-tabs">
              <ul class="nav nav-tabs nav-tabs-transparent indicator-primary nav-tabs-full nav-tabs-3" role="tablist">
                <li class="nav-item">
                  <a href="#posts" aria-controls="posts" role="tab" data-toggle="tab" class="nav-link withoutripple active">
                      <i class="no-mr zmdi zmdi-format-list-bulleted"></i>
                    </a>
                </li>

                <li class="nav-item">
                  <a href="#tags" aria-controls="tags" role="tab" data-toggle="tab" class="nav-link withoutripple">
                      <i class="no-mr zmdi zmdi-book"></i>
                    </a>
                </li>

                <li class="nav-item">
                  <a href="#archives" aria-controls="archives" role="tab" data-toggle="tab" class="nav-link withoutripple">
                      <i class="no-mr zmdi zmdi-time"></i>
                    </a>
                </li>

              </ul>
            </div>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade active show" id="posts">
                <div class="list-group">
                  <?php foreach ($all_posts as $p):
                    $link = $router->pathFor('view-post', ['hyperlink'=>$p->getHyperlink()])?>
                    <a href="<?=$link?>" class="list-group-item list-group-item-action withripple <?=$p == $post?"active":""?>">
                        <span> <?=$p->getTitle()?></span>
                      </a>
                  <?php endforeach; ?>

                </div>
              </div>

              <div role="tabpanel" class="tab-pane fade" id="tags">
                <div class="card-body overflow-hidden text-center">
                  <?php foreach ($all_libraries as $lib){
                    $lib_name = $lib->getName();?>
                    <a href="<?=$router->pathFor('library', ['name'=>$lib_name])?>"
                      class="ms-tag ms-tag-primary"><?=$lib_name?></a>
                  <?php } ?>
                </div>
              </div>

              <div role="tabpanel" class="tab-pane fade" id="archives">
                <div class="list-group">
                  <a href="#" class="list-group-item list-group-item-action withripple invisible">
                      <span> Title</span>
                    </a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="ad-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg animated zoomIn animated-3x" role="document">
        <div class="modal-content">
            <fieldset>
              <div class="modal-header">
                <h3 class="modal-title color-danger" id="myModalLabel">Adblocker detected</h3>
              </div>
              <div class="modal-body container">
                <p>Hate ads? I do too, but ads help me run this website. Please turn off any ad blockers and reload this page. Thank you.</p>

              </div>
              <div class="modal-footer">
                <button onclick="location.reload()" type="submit" class="btn btn-success">Reload</button>
              </div>
            </fieldset>
        </div>
      </div>
    </div>
    <!-- container -->
    <?php require_once('templates/footer.php')?>
  </div>
  <!-- ms-site-container -->
  <?php require_once('templates/slidebar.php')?>
  <script src="<?=$home?>assets/js/plugins.min.js"></script>
  <script src="<?=$home?>assets/js/app.min.js"></script>
  <script src="<?=$home?>assets/js/highlight.min.js"></script>
  <script src="<?=$home?>assets/js/js-cookie.js"></script>
  <script src="<?=$home?>assets/js/blockadblock.js"></script>
  <script src="<?=$home?>assets/js/view-post.js"></script>
</body>

</html>
