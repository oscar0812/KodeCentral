<!DOCTYPE html>
<html lang="en">
  <?php $home = replaceLast('index.php/', '', $router->pathFor('home'));?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central</title>
    <meta name="description" content="Kode Central, a place for programmers">
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
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12 col-md-6 order-md-1">
                <div class="card animated fadeInUp animation-delay-7">
                  <div class="ms-hero-bg-primary ms-hero-img-coffee">
                    <h3 class="color-white index-1 text-center no-m pt-4"><?=$user->getUsername()?></h3>
                    <div class="color-medium index-1 text-center np-m">@<?=$user->getUsername()?></div>
                    <img src="<?=$home?>assets/img/demo/avatar1.jpg" alt="..." class="img-avatar-circle"> </div>
                  <div class="card-body pt-4 text-center">
                    <h3 class="color-primary">Bio</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur alter adipisicing elit. Facilis, natuse inse voluptates officia repudiandae beatae magni es magnam autem molestias.</p>
                    <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                      <i class="zmdi zmdi-facebook"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                      <i class="zmdi zmdi-twitter"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                      <i class="zmdi zmdi-instagram"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 order-md-3 order-lg-2">
                <a href="javascript:void(0)" class="btn btn-warning btn-raised btn-block animated fadeInUp animation-delay-12">
                  <i class="zmdi zmdi-edit"></i> Edit Profile</a>
                <a href="<?=$router->pathFor('user-logout')?>" class="btn btn-danger btn-raised btn-block animated fadeInUp animation-delay-12">
                  <i class="fa fa-sign-out"></i> Log Out</a>
              </div>
              <div class="col-lg-12 col-md-6 order-md-2 order-lg-3">
                <div class="card animated fadeInUp animation-delay-12">
                  <div class="ms-hero-bg-royal ms-hero-img-mountain">
                    <h3 class="color-white index-1 text-center pb-4 pt-4">Recent Contacts</h3>
                  </div>
                  <div class="card-body">
                    <div class="ms-media-list">
                      <div class="media mb-2">
                        <a class="mr-3" href="#">
                          <img class="media-object" src="<?=$home?>assets/img/demo/avatar1.jpg"> </a>
                        <div class="media-body">
                          <h4 class="mt-0 mb-0 color-warning">Maria Sharaphova</h4>
                          <a href="mailto:joe@example.com?subject=feedback">maria.sha@example.com</a>
                          <div class="">
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-facebook">
                              <i class="zmdi zmdi-facebook"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-twitter">
                              <i class="zmdi zmdi-twitter"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-instagram">
                              <i class="zmdi zmdi-instagram"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="media mb-2">
                        <div class="media-left media-middle">
                          <a class="mr-3" href="#">
                            <img class="media-object" src="<?=$home?>assets/img/demo/avatar1.jpg"> </a>
                        </div>
                        <div class="media-body">
                          <h4 class="mt-0 mb-0 color-warning">Rafael Nadal</h4>
                          <a href="mailto:joe@example.com?subject=feedback">rafa.nad@example.com</a>
                          <div class="">
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-facebook">
                              <i class="zmdi zmdi-facebook"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-twitter">
                              <i class="zmdi zmdi-twitter"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-instagram">
                              <i class="zmdi zmdi-instagram"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="media mb-2">
                        <div class="media-left media-middle">
                          <a class="mr-3" href="#">
                            <img class="media-object" src="<?=$home?>assets/img/demo/avatar1.jpg"> </a>
                        </div>
                        <div class="media-body">
                          <h4 class="mt-0 mb-0 color-warning">Roger Federer</h4>
                          <a href="mailto:joe@example.com?subject=feedback">roger.fef@example.com</a>
                          <div class="">
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-facebook">
                              <i class="zmdi zmdi-facebook"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-twitter">
                              <i class="zmdi zmdi-twitter"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn-circle btn-circle-xs no-mr-md btn-instagram">
                              <i class="zmdi zmdi-instagram"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="row">
              <div class="col-sm-4">
                <div class="card card-info card-body overflow-hidden text-center wow zoomInUp animation-delay-2">
                  <h2 class="counter color-info">450</h2>
                  <i class="fa fa-4x fa-file-text color-info"></i>
                  <p class="mt-2 no-mb lead small-caps color-info">articles</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="card card-success card-body overflow-hidden text-center wow zoomInUp animation-delay-5">
                  <h2 class="counter color-success">64</h2>
                  <i class="fa fa-4x fa-briefcase color-success"></i>
                  <p class="mt-2 no-mb lead small-caps color-success">projects done</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="card card-royal card-body overflow-hidden text-center wow zoomInUp animation-delay-4">
                  <h2 class="counter color-royal">600</h2>
                  <i class="fa fa-4x fa-comments-o color-royal"></i>
                  <p class="mt-2 no-mb lead small-caps color-royal">comments</p>
                </div>
              </div>
            </div>
            <div class="card card-primary animated fadeInUp animation-delay-12">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-account-circle"></i> General Information</h3>
              </div>
              <table class="table table-no-border table-striped">
                <tr>
                  <th>
                    <i class="zmdi zmdi-account mr-1 color-success"></i> User Name</th>
                  <td><?=$user->getUsername()?></td>
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
                  <td><?=$user->getJoinDate()->format('m/d/Y')?></td>
                </tr>
              </table>
            </div>
            <h2 class="color-primary text-center mt-4 mb-2">Recent Activity</h2>
            <div class="row">
              <div class="col-lg-12">
                <ul class="ms-timeline">
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2016
                        <span>March</span>
                      </time>
                      <i class="ms-timeline-point bg-royal"></i>
                      <img src="<?=$home?>assets/img/demo/avatar1.jpg" class="ms-timeline-point-img"> </div>
                    <div class="card card-royal">
                      <div class="card-header">
                        <h3 class="card-title">Card Title</h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <img src="<?=$home?>assets/img/demo/office1.jpg" alt="" class="img-fluid"> </div>
                          <div class="col-sm-8">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum, praesentium, quam! Quia fugiat aperiam.</p>
                            <p>Perspiciatis soluta voluptate dolore officiis libero repellat cupiditate explicabo atque facere aliquam.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2015
                        <span>October</span>
                      </time>
                      <i class="ms-timeline-point bg-info"></i>
                    </div>
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Card Title</h3>
                      </div>
                      <div class="list-group">
                        <a href="javascript:void(0)" class="list-group-item withripple">
                          <i class="zmdi zmdi-favorite"></i>Cras justo odio
                          <span class="label label-default pull-right">Active</span>
                        </a>
                        <a href="javascript:void(0)" class="list-group-item withripple">
                          <i class="zmdi zmdi-cocktail"></i> Dapibus ac facilisis in
                          <span class="label label-primary pull-right">Other</span>
                        </a>
                        <a href="javascript:void(0)" class="list-group-item withripple active">
                          <i class="zmdi zmdi-cast"></i>Morbi leo risus
                          <span class="label label-default pull-right">New</span>
                        </a>
                        <a href="javascript:void(0)" class="list-group-item withripple">
                          <i class="zmdi zmdi-city"></i>Porta ac consectetur ac
                          <span class="label label-warning pull-right">Two words</span>
                        </a>
                        <a href="javascript:void(0)" class="list-group-item withripple">
                          <i class="zmdi zmdi-chart"></i>Vestibulum at eros
                          <span class="label label-success pull-right">Success</span>
                        </a>
                      </div>
                    </div>
                  </li>
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2015
                        <span>October</span>
                      </time>
                      <i class="ms-timeline-point bg-success"></i>
                    </div>
                    <div class="card card-success-inverse">
                      <div class="card-body"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus officiis autem magni et, nisi eveniet nulla magnam tenetur voluptatem dolore, assumenda delectus error porro animi architecto dolorum quod veniam nesciunt.
                        </div>
                    </div>
                  </li>
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2015
                        <span>February</span>
                      </time>
                      <i class="ms-timeline-point bg-warning"></i>
                      <img src="<?=$home?>assets/img/demo/avatar1.jpg" class="ms-timeline-point-img"> </div>
                    <div class="card card-warning">
                      <div class="card-header">
                        <h3 class="card-title">Card Title</h3>
                      </div>
                      <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam, nulla recusandae blanditiis architecto soluta culpa obcaecati quis earum atque consequuntur.</p>
                        <div class="row">
                          <div class="col-sm-4">
                            <img src="<?=$home?>assets/img/demo/office2.jpg" alt="" class="img-fluid"> </div>
                          <div class="col-sm-4">
                            <img src="<?=$home?>assets/img/demo/office3.jpg" alt="" class="img-fluid"> </div>
                          <div class="col-sm-4">
                            <img src="<?=$home?>assets/img/demo/office4.jpg" alt="" class="img-fluid"> </div>
                        </div>
                        <br>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, ipsum voluptates eius placeat dolorum reprehenderit ducimus accusamus magni aspernatur at dolore assumenda quae suscipit enim veritatis obcaecati molestias laudantium
                          maxime!</p>
                      </div>
                    </div>
                  </li>
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2014
                        <span>July</span>
                      </time>
                      <i class="ms-timeline-point"></i>
                    </div>
                    <div class="card">
                      <blockquote class="blockquote blockquote-color-bg-primary withripple color-white">
                        <p>
                          <strong>Blockquote in timeline!</strong> consectetur adipiscing elit. Integer sodales sagittis magna. consectetur adipiscing elit sed consequat, quam semper libero.</p>
                        <footer>Someone famous in
                          <cite title="Source Title">Source Title</cite>
                        </footer>
                      </blockquote>
                    </div>
                  </li>
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2014
                        <span>January</span>
                      </time>
                      <i class="ms-timeline-point bg-info"></i>
                      <img src="<?=$home?>assets/img/demo/avatar1.jpg" class="ms-timeline-point-img"> </div>
                    <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Card Title</h3>
                      </div>
                      <div class="js-player" data-plyr-provider="youtube" data-plyr-embed-id="9ZfN87gSjvI"></div>
                    </div>
                  </li>
                  <li class="ms-timeline-item wow materialUp">
                    <div class="ms-timeline-date">
                      <time class="timeline-time" datetime="">2013
                        <span>June</span>
                      </time>
                      <i class="ms-timeline-point"></i>
                    </div>
                    <div class="card">
                      <div class="ms-hero-bg-primary ms-hero-img-coffee">
                        <h3 class="color-white index-1 text-center no-m pt-4">Victoria Smith</h3>
                        <div class="color-medium index-1 text-center np-m">@vic_smith</div>
                        <img src="<?=$home?>assets/img/demo/avatar1.jpg" alt="..." class="img-avatar-circle"> </div>
                      <div class="card-body pt-4 text-center">
                        <h3 class="color-primary">Bio</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur alter adipisicing elit. Facilis, natuse inse voluptates officia repudiandae beatae magni es magnam autem molestias.</p>
                        <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-facebook">
                          <i class="zmdi zmdi-facebook"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-twitter">
                          <i class="zmdi zmdi-twitter"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn-circle btn-circle-raised btn-circle-xs mt-1 mr-1 no-mr-md btn-instagram">
                          <i class="zmdi zmdi-instagram"></i>
                        </a>
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
      <?php require_once('templates/footer.php')?>
    </div>
    <?php require_once('templates/slidebar.php')?>
    <!-- ms-site-container -->
    <script src="<?=$home?>assets/js/plugins.min.js"></script>
    <script src="<?=$home?>assets/js/app.min.js"></script>
  </body>
</html>
