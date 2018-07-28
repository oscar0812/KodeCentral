<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central</title>
    <meta name="description" content="Material Style Theme">
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
      <div class="container">
        <h1 class="right-line mb-4">My Posts</h1>
        <div class="row">
          <div class="col-md-9">
            <?php foreach ($posts as $post) { ?>
              <div class="card mb-1">
                <table class="table table-no-border vertical-center">
                  <tr>
                    <td class="d-none d-sm-block">
                      <img src="assets/img/demo/products/m1.png" alt=""> </td>
                    <td>
                      <h4 class=""><?=$post->getTitle()?></h4>
                    </td>
                    <td>
                      <span class="color-info"><?=$post->getPostedDate()->format('F d,Y')?></span>
                    </td>
                    <td>
                      <button class="btn btn-success"
                      data-url="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>">
                        <i class="zmdi zmdi-eye"></i> View</button>
                    </td>
                    <td>
                      <button class="btn btn-danger">
                        <i class="zmdi zmdi-delete"></i></button>
                    </td>
                  </tr>
                </table>
              </div>
            <?php }?>

          </div>
          <div class="col-md-3">
            <div class="card card-info">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Summary</div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li>
                    <strong>Price: </strong> $1984.26</li>
                  <li>
                    <strong>Tax: </strong> $47.22</li>
                  <li>
                    <strong>Tax: </strong> $47.22</li>
                  <li>
                    <strong>Shipping costs: </strong>
                    <span class="color-warning">$5.25</span>
                  </li>
                </ul>
                <h3>
                  <strong>Total:</strong>
                  <span class="color-info">$2456.45</span>
                </h3>
                <a href="<?=$router->pathFor('create-post')?>" class="btn btn-raised btn-info btn-block btn-raised mt-2 no-mb">
                  <i class="zmdi zmdi-plus"></i> Create new</a>
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
