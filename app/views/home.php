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
    <link rel="shortcut icon" href="assets/img/favicon.png?v=3">
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
            <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">Blog</h1>
            <p class="lead lead-lg color-white text-center center-block mt-2 mb-4 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">Discover our projects and the
              <span class="color-warning">rigorous process</span> of creation. Our principles are creativity, design, experience and knowledge.</p>
            <a href="javascript:void(0)" class="btn btn-raised btn-warning animated fadeInUp animation-delay-10">
              <i class="zmdi zmdi-accounts"></i> Become a member</a>
            <a href="javascript:void(0)" class="btn btn-raised btn-info animated fadeInUp animation-delay-10">
              <i class="zmdi zmdi-email"></i> Concact us</a>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 d-none d-lg-block">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-filter-list"></i>Filter List</h3>
              </div>
              <div class="card-body no-pb">
                <form class="form-horizontal">
                  <h4 class="no-m color-primary">Categories</h4>
                  <div class="form-group mt-1">
                    <div class="radio no-mb">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios0" value="option0" checked="" class="filter" data-filter="all"> All </label>
                    </div>
                    <?php foreach($categories as $category) { ?>
                    <div class="radio no-mb">
                      <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios<?=$category->getId()?>" value="option<?=$category->getId()?>" class="filter" data-filter=".category-<?=$category->getName()?>"> <?=$category->getName()?> </label>
                    </div>
                    <?php } ?>

                  </div>
                </form>
                <h4 class="mt-2 color-primary no-mb">Columns</h4>
              </div>
              <ul class="nav nav-tabs nav-tabs-transparent indicator-primary nav-tabs-full nav-tabs-4" role="tablist">
                <li class="nav-item">
                  <a id="Cols1" class="nav-link withoutripple" href="#home7" aria-controls="home7" role="tab" data-toggle="tab">1</a>
                </li>
                <li class="nav-item">
                  <a id="Cols2" class="nav-link withoutripple" href="#profile7" aria-controls="profile7" role="tab" data-toggle="tab">2</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="Cols3" class="nav-link active withoutripple" href="#messages7" aria-controls="messages7" role="tab" data-toggle="tab">3</a>
                </li>
                <li class="nav-item">
                  <a id="Cols4" class="nav-link withoutripple" href="#settings7" aria-controls="settings7" role="tab" data-toggle="tab">4</a>
                </li>
              </ul>
              <div class="card-body pr-0">
                <form class="form-horizontal">
                  <div class="form-group no-mt">
                    <h4 class="no-m color-primary mb-2">Descriptions</h4>
                    <div class="togglebutton">
                      <label>
                        <input id="port-show" type="checkbox"> Show description </label>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="row" id="Container">
              <?php foreach($posts as $post) { ?>
              <div class="col-md-4 col-sm-6 mix category-Bots">
                <div class="card width-auto">
                  <figure class="ms-thumbnail">
                    <img src="assets/img/demo/port1.jpg" alt="" class="img-fluid">
                    <figcaption class="ms-thumbnail-caption text-center">
                      <div class="ms-thumbnail-caption-content">
                        <h4 class="ms-thumbnail-caption-title mb-2"><?=$post->getTitle()?></h4>
                        <a href="<?=$router->pathFor('blog-post', ['hyperlink'=>$post->getHyperlink()])?>" class="btn-circle btn-circle-raised btn-circle-xs mr-1 btn-circle-white color-info">
                          <i class="zmdi zmdi-eye"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs ml-1 mr-1 btn-circle-white color-danger">
                          <i class="zmdi zmdi-favorite"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs ml-1 btn-circle-white color-success">
                          <i class="zmdi zmdi-share"></i>
                        </a>
                      </div>
                    </figcaption>
                  </figure>
                  <div class="card-body overflow-hidden text-center portfolio-item-caption d-none">
                    <h3 class="color-primary no-mt"><?=$post->getTitle()?></h3>
                    <p><?=$post->getSummary()?></p>
                  </div>
                </div>
              </div>
              <!-- item -->
             <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- container-fluid -->
      <?php require_once('templates/footer.php') ?>
    </div>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/portfolio.js"></script>
  </body>
</html>
