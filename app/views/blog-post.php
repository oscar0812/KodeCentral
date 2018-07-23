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
    <meta name="description" content="Material Style Theme">
    <link rel="shortcut icon" href="<?=$home?>assets/img/favicon.png?v=3">
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
        <div class="row">
          <div class="col-lg-8">
            <div class="card animated fadeInLeftTiny animation-delay-5">
              <div class="card-body card-body-big">
                <h1 class="no-mt"><?=$post->getTitle()?></h1>
                <div class="mb-4">
                  <img src="<?=$home?>assets/img/demo/avatar50.jpg" alt="..." class="img-circle mr-1"> by
                  <?php $username = $post->getUser()->getUsername();?>
                  <a href="<?=$router->pathFor('user-profile', ['username'=>$username])?>"><?=$username?></a> in
                  <?php foreach ($post->getCategories() as $category) { ?>
                  <a href="javascript:void(0)" class="ms-tag ms-tag-info"><?=$category->getName()?></a>
                  <?php } ?>
                  <span class="ml-1 d-none d-sm-inline">
                    <i class="zmdi zmdi-time mr-05 color-info"></i>
                    <span class="color-medium-dark"><?=$post->getPostedDate()->format('M d, Y')?></span>
                  </span>
                  <span class="ml-1">
                    <i class="zmdi zmdi-comments color-royal mr-05"></i> 25</span>
                </div>
                <!-- post text here -->

                <?=$post->getText()?>

                <!-- post text ends here -->
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-primary animated fadeInUp animation-delay-7">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-apps"></i> Navigation</h3>
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

        <div class="row masonry-container">
          <div class="col-md-4 masonry-item">
            <article class="card card-info mb-4">
              <figure class="ms-thumbnail ms-thumbnail-left">
                <img src="<?=$home?>assets/img/demo/post1.jpg" alt="" class="img-fluid">
                <figcaption class="ms-thumbnail-caption text-center">
                  <div class="ms-thumbnail-caption-content">
                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <div class="mt-2">
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm mr-1 btn-circle-white color-danger">
                        <i class="zmdi zmdi-favorite"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm ml-1 mr-1 btn-circle-white color-warning">
                        <i class="zmdi zmdi-star"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm ml-1 btn-circle-white color-success">
                        <i class="zmdi zmdi-share"></i>
                      </a>
                    </div>
                  </div>
                </figcaption>
              </figure>
            </article>
          </div>
          <div class="col-md-4 masonry-item">
            <article class="card card-danger mb-4">
              <figure class="ms-thumbnail ms-thumbnail-left">
                <img src="<?=$home?>assets/img/demo/post5.jpg" alt="" class="img-fluid">
                <figcaption class="ms-thumbnail-caption text-center">
                  <div class="ms-thumbnail-caption-content">
                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <div class="mt-2">
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm mr-1 btn-circle-white color-danger">
                        <i class="zmdi zmdi-favorite"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm ml-1 mr-1 btn-circle-white color-warning">
                        <i class="zmdi zmdi-star"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm ml-1 btn-circle-white color-success">
                        <i class="zmdi zmdi-share"></i>
                      </a>
                    </div>
                  </div>
                </figcaption>
              </figure>
            </article>
          </div>
          <div class="col-md-4 masonry-item">
            <article class="card card-success mb-4">
              <figure class="ms-thumbnail ms-thumbnail-left">
                <img src="<?=$home?>assets/img/demo/post5.jpg" alt="" class="img-fluid">
                <figcaption class="ms-thumbnail-caption text-center">
                  <div class="ms-thumbnail-caption-content">
                    <h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <div class="mt-2">
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm mr-1 btn-circle-white color-danger">
                        <i class="zmdi zmdi-favorite"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm ml-1 mr-1 btn-circle-white color-warning">
                        <i class="zmdi zmdi-star"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-sm ml-1 btn-circle-white color-success">
                        <i class="zmdi zmdi-share"></i>
                      </a>
                    </div>
                  </div>
                </figcaption>
              </figure>
            </article>
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
  </body>
</html>
