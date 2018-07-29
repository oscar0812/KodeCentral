<!DOCTYPE html>
<html lang="en">
  <?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | <?=$post->getTitle()?></title>
    <meta name="description" content="Kode Central, a place for programmers">
    <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.png?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?=$home?>assets/css/preload.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/plugins.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/css/style.blue-600.min.css">
    <link rel="stylesheet" href="<?=$home?>assets/plugins/quill/css/monokai-sublime.min.css">
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
        <div class="row">
          <div class="col-lg-8">
            <div class="card animated fadeInLeftTiny animation-delay-5">
              <div class="card-body card-body-big">
                <h1 class="no-mt"><?=$post->getTitle()?></h1>

                <div class="mb-4" id="user-info">
                  <img src="<?=$home?>assets/img/demo/avatar50.jpg" alt="..." class="img-circle mr-1"> by
                  <?php $username = $post->getPostedByUser()->getUsername();?>
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$username])?>">
                  <?=$post->getPostedByUser() == $user?$username." (You)":$username?></a> in
                  <?php foreach ($post->getCategories() as $category) { ?>
                  <a href="javascript:void(0)" class="ms-tag ms-tag-info"><?=$category->getName()?></a>
                  <?php } ?>
                  <span class="ml-1 d-none d-sm-inline">
                    <i class="zmdi zmdi-time mr-05 color-info"></i>
                    <span class="color-medium-dark"><?=$post->getPostedDate()->format('F d, Y')?></span>
                  </span>
                  <?php if($user!= null && $post->getPostedByUser() == $user) { ?>
                  <span class="ml-1 d-none d-sm-inline">
                    <a href="<?=$router->pathFor('edit-post', ['hyperlink'=>$post->getHyperlink()])?>">
                      <i class="fa fa-pencil"> Edit</i>
                    </a>
                  <?php } ?>
                  </span>
                </div>
                <!-- post text here -->
                <div id="post-text"><?=$post->getText()?></div>
                <!-- post text ends here -->
              </div>
            </div>

            <h2 class="right-line no-mt">Comments (<?=$comments->count()?>)</h2>

            <div class="card animated fadeInLeftTiny animation-delay-5">
              <div class="card-body" id="comment-body">

                <div class="invisible" id="comment-template">
                  <div class="ms-icon-feature-icon">
                    <img src="<?=$home?>assets/img/demo/avatar50.jpg" alt="..." class="img-circle mr-1">
                  </div>
                  <div class="ms-icon-feature-content">
                    <a href="#">username</a>
                    <p>Text</p>
                  </div>
                </div>

                <?php foreach ($comments as $comment) { ?>
                  <div class="ms-icon-feature">
                    <div class="ms-icon-feature-icon">
                      <img src="<?=$home?>assets/img/demo/avatar50.jpg" alt="..." class="img-circle mr-1">
                    </div>
                    <div class="ms-icon-feature-content">
                      <?php $username = $comment->getUser()->getUsername();?>
                      <a href="<?=$router->pathFor('user-profile', ['username'=>$username])?>"><?=$username?>
                        <?php if($comment->getUser() == $user) echo " (You)"?>
                      </a>
                      <p><?=$comment->getText()?></p>
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
          <div class="col-lg-4">
            <ol class="breadcrumb">

              <li class="breadcrumb-item"><a href="<?=$router->pathFor('home')?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=$router->pathFor('library', ['name'=>$lib_name])?>"><?=$lib_name?></a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$post->getTitle()?></li>

            </ol>
            <div class="card card-primary animated fadeInUp animation-delay-7">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-apps"></i> Navigation
                </h3>
              </div>
              <div class="card-tabs">
                <ul class="nav nav-tabs nav-tabs-transparent indicator-primary nav-tabs-full nav-tabs-4" role="tablist">
                  <li class="nav-item">
                    <a href="#favorite" aria-controls="favorite" role="tab" data-toggle="tab" class="nav-link withoutripple active">
                      <i class="no-mr zmdi zmdi-star"></i>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#categories" aria-controls="categories" role="tab" data-toggle="tab" class="nav-link withoutripple">
                      <i class="no-mr zmdi zmdi-folder"></i>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#archives" aria-controls="archives" role="tab" data-toggle="tab" class="nav-link withoutripple">
                      <i class="no-mr zmdi zmdi-time"></i>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#tags" aria-controls="tags" role="tab" data-toggle="tab" class="nav-link withoutripple">
                      <i class="no-mr zmdi zmdi-tag-more"></i>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active show" id="favorite">
                  <div class="card-body">
                    <div class="ms-media-list">
                      <div class="media mb-2">
                        <div class="media-left media-middle">
                          <a href="#">
                            <img class="d-flex mr-3 media-object media-object-circle" src="<?=$home?>assets/img/demo/p75.jpg" alt="..."> </a>
                        </div>
                        <div class="media-body">
                          <a href="javascript:void(0)" class="media-heading">Lorem ipsum dolor sit amet in consectetur adipisicing</a>
                          <div class="media-footer text-small">
                            <span class="mr-1">
                              <i class="zmdi zmdi-time color-info mr-05"></i> August 18, 2016</span>
                            <span>
                              <i class="zmdi zmdi-folder-outline color-success mr-05"></i>
                              <a href="javascript:void(0)">Design</a>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="media mb-2">
                        <div class="media-left media-middle">
                          <a href="#">
                            <img class="d-flex mr-3 media-object media-object-circle" src="<?=$home?>assets/img/demo/p75.jpg" alt="..."> </a>
                        </div>
                        <div class="media-body">
                          <a href="javascript:void(0)" class="media-heading">Nemo enim ipsam voluptatem quia voluptas sit aspernatur</a>
                          <div class="media-footer text-small">
                            <span class="mr-1">
                              <i class="zmdi zmdi-time color-info mr-05"></i> August 18, 2016</span>
                            <span>
                              <i class="zmdi zmdi-folder-outline color-danger mr-05"></i>
                              <a href="javascript:void(0)">Productivity</a>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="media">
                        <div class="media-left media-middle">
                          <a href="#">
                            <img class="d-flex mr-3 media-object media-object-circle" src="<?=$home?>assets/img/demo/p75.jpg" alt="..."> </a>
                        </div>
                        <div class="media-body">
                          <a href="javascript:void(0)" class="media-heading">inventore veritatis et vitae quasi architecto beatae </a>
                          <div class="media-footer text-small">
                            <span class="mr-1">
                              <i class="zmdi zmdi-time color-info mr-05"></i> August 18, 2016</span>
                            <span>
                              <i class="zmdi zmdi-folder-outline color-royal-light mr-05"></i>
                              <a href="javascript:void(0)">Resources</a>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="categories">
                  <div class="list-group">
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class=" color-info zmdi zmdi-cocktail"></i>Design
                      <span class="ml-auto badge-pill badge-pill-info">25</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class=" color-warning zmdi zmdi-collection-image"></i> Graphics
                      <span class="ml-auto badge-pill badge-pill-warning">14</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class=" color-danger zmdi zmdi-case-check"></i> Productivity
                      <span class="ml-auto badge-pill badge-pill-danger">7</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class=" color-royal zmdi zmdi-folder-star-alt"></i>Resources
                      <span class="ml-auto badge-pill badge-pill-royal">67</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class=" color-success zmdi zmdi-play-circle-outline"></i>Multimedia
                      <span class="ml-auto badge-pill badge-pill-success">32</span>
                    </a>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="archives">
                  <div class="list-group">
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class="zmdi zmdi-calendar"></i> January 2016
                      <span class="ml-auto badge-pill">25</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class="zmdi zmdi-calendar"></i> February 2016
                      <span class="ml-auto badge-pill">14</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class="zmdi zmdi-calendar"></i> March 2016
                      <span class="ml-auto badge-pill">9</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class="zmdi zmdi-calendar"></i> April 2016
                      <span class="ml-auto badge-pill">12</span>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                      <i class="zmdi zmdi-calendar"></i> June 2016
                      <span class="ml-auto badge-pill">65</span>
                    </a>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tags">
                  <div class="card-body overflow-hidden text-center">
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Design</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Productivity</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Web</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Resources</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Multimedia</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">HTML5</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">CSS3</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Javascript</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Jquery</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Bootstrap</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Angular</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Gulp</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Atom</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Fonts</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Pictures</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Developers</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Code</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">SASS</a>
                    <a href="javascript:void(0)" class="ms-tag ms-tag-primary">Less</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-primary animated fadeInUp animation-delay-7">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-widgets"></i> Text Widget</h3>
              </div>
              <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat ipsam non eaque est architecto doloribus, labore nesciunt laudantium, ex id ea, cum facilis similique tenetur fugit nemo id minima possimus.</p>
              </div>
            </div>
          </div>
        </div>
        <h2 class="right-line mt-6">Related Posts</h2>
        <div class="row">
          <?php foreach ($related_posts as $post) { ?>
            <div class="col-md-4 masonry-item">
              <article class="card mb-4">
                <figure class="ms-thumbnail ms-thumbnail-left">
                  <img src="<?=$home?>assets/img/demo/post1.jpg" alt="" class="img-fluid">
                  <figcaption class="ms-thumbnail-caption text-center">
                    <div class="ms-thumbnail-caption-content">
                      <h4 class="ms-thumbnail-caption-title mb-2"><?=$post->getTitle()?></h4>
                      <a href="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>" class="btn-circle btn-circle-raised btn-circle-xs mr-1 btn-circle-white color-info">
                        <i class="zmdi zmdi-eye"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs ml-1 mr-1 btn-circle-white color-danger">
                        <i class="zmdi zmdi-favorite"></i>
                      </a>
                    </div>
                  </figcaption>
                </figure>
              </article>
            </div>
          <?php } ?>
        </div>
      </div>
      <!-- container -->
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="<?=$home?>assets/js/plugins.min.js"></script>
    <script src="<?=$home?>assets/js/app.min.js"></script>
    <script src="<?=$home?>assets/plugins/quill/js/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script type="text/javascript">
      $(function(){
        $('#comment-form').on('submit', function(e){
          ajaxForm(e.target, function(data) {
            // comment is being posted
            if(data['success']){
              info = $('#user-info');
              // get the template
              template = $('#comment-template').clone().
                addClass('ms-icon-feature').removeClass('invisible');

              // pfp and name are the same as the user signed in, so get them
              // from the post contect
              pfp = template.find('.ms-icon-feature-icon>img').
                attr('src', info.find('img').attr('src'));

              new_name = template.find('.ms-icon-feature-content>a');
              current_name = info.find('a').eq(0);

              new_name.attr('href', current_name.attr('href')).
                text(current_name.text());

              // set the comment text
              template.find('.ms-icon-feature-content>p').text(data['text']);

              // clear the textarea
              $('textarea[name="text"]').val('');

              // add the comment to the comment section
              $('#comment-body').prepend(template);
            }
          });
          return false;
        });
      });
    </script>
  </body>
</html>
