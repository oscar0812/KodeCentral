<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central</title>
    <meta name="description" content="Kode Central, a place for programmers">
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
      <div class="material-background"></div>
      <div class="container container-full">
        <div class="card animated slideInUp animation-delay-8 mb-6">
          <div class="card-body-big">
            <h2 class="right-line right-line-white">Home</h2>
            <div class="row">
              <div class="col-md-6">
                <h3 class="color-primary mt-4">General &amp; Landing</h3>
                <ul class="list-line">
                  <li>
                    <a href="<?=$router->pathFor('home')?>">Default Home</a>
                  </li>
                  <li>
                    <a href="home-generic-2.php">Home Black Slider</a>
                  </li>
                  <li>
                    <a href="home-generic-3.php">Home Browsers Intro</a>
                  </li>
                  <li>
                    <a href="home-generic-4.php">Home Mobile Intro</a>
                  </li>
                  <li>
                    <a href="home-generic-5.php">Home Material Icons</a>
                  </li>
                  <li>
                    <a href="home-generic-6.php">Home Typed Hero</a>
                  </li>
                  <li>
                    <a href="home-generic-7.php">Home Typed Hero 2</a>
                  </li>
                  <li>
                    <a href="home-landing.php">Home Landing Intro</a>
                  </li>
                  <li>
                    <a href="home-landing2.php">Home Landing Intro 2</a>
                  </li>
                  <li>
                    <a href="home-landing4.php">Home Landing Intro 3</a>
                  </li>
                  <li>
                    <a href="home-landing3.php">Home Landing Video</a>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <h3 class="color-primary mt-4">Others</h3>
                <ul class="list-line">
                  <li>
                    <a href="home-shop.php">Home Shop 1</a>
                  </li>
                  <li>
                    <a href="home-shop2.php">Home Shop 2</a>
                  </li>
                  <li>
                    <a href="home-cv.php">Home Profile 1</a>
                  </li>
                  <li>
                    <a href="home-cv2.php">Home Profile 2</a>
                  </li>
                  <li>
                    <a href="home-cv3.php">Home Profile Landing 1</a>
                  </li>
                  <li>
                    <a href="home-cv4.php">Home Profile Landing 2</a>
                  </li>
                  <li>
                    <a href="home-blog.php">Home Blog 1</a>
                  </li>
                  <li>
                    <a href="<?=$router->pathFor('home')?>">Home Blog 2</a>
                  </li>
                  <li>
                    <a href="home-magazine.php">Home Magazine 1</a>
                  </li>
                  <li>
                    <a href="home-app.php">Home App 1</a>
                  </li>
                  <li>
                    <a href="home-app2.php">Home App 2</a>
                  </li>
                  <li>
                    <a href="home-class.php">Home Classifieds 1</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- row -->
            <h2 class="right-line right-line-white">Pages</h2>
            <div class="row">
              <div class="col-md-6">
                <h3 class="color-primary mt-4">About us &amp; Team</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-about.php">About us Option 1</a>
                  </li>
                  <li>
                    <a href="page-about2.php">About us Option 2</a>
                  </li>
                  <li>
                    <a href="page-about3.php">About us Option 3</a>
                  </li>
                  <li>
                    <a href="page-about4.php">About us Option 4</a>
                  </li>
                  <li>
                    <a href="page-team.php">Our Team Option 1</a>
                  </li>
                  <li>
                    <a href="page-team2.php">Our Team Option 2</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Profile</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-profile.php">User Profile Option 1</a>
                  </li>
                  <li>
                    <a href="page-profile2.php">User Profile Option 2</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Bussiness &amp; Products</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-testimonial.php">Testimonials</a>
                  </li>
                  <li>
                    <a href="page-clients.php">Our Clients</a>
                  </li>
                  <li>
                    <a href="page-product.php">Products</a>
                  </li>
                  <li>
                    <a href="page-services.php">Services</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">FAQ &amp; Support</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-support.php">Support Center</a>
                  </li>
                  <li>
                    <a href="page-faq.php">FAQ Option 1</a>
                  </li>
                  <li>
                    <a href="page-faq2.php">FAQ Option 2</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Timeline</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-timeline_left.php">Timeline Left</a>
                  </li>
                  <li>
                    <a href="page-timeline_left2.php">Timeline Left 2</a>
                  </li>
                  <li>
                    <a href="page-timeline.php">Timeline Center</a>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <h3 class="color-primary mt-4">Form</h3>
                <ul class="list-line">
                  <li>
                    <a href="<?=$router->pathFor('contact-us')?>">Contact Option 1</a>
                  </li>
                  <li>
                    <a href="page-contact2.php">Contact Option 2</a>
                  </li>
                  <li>
                    <a href="page-login_register.php">Login &amp; Register</a>
                  </li>
                  <li>
                    <a href="page-login.php">Login Full</a>
                  </li>
                  <li>
                    <a href="page-login2.php">Login Integrated</a>
                  </li>
                  <li>
                    <a href="page-login_register2.php">Register Option 1</a>
                  </li>
                  <li>
                    <a href="page-register2.php">Register Option 2</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Error</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-404.php">Error 404 Full Page</a>
                  </li>
                  <li>
                    <a href="page-404_2.php">Error 404 Integrated</a>
                  </li>
                  <li>
                    <a href="page-500.php">Error 500 Full Page</a>
                  </li>
                  <li>
                    <a href="page-500_2.php">Error 500 Integrated</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Pricing</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-pricing.php">Pricing Box</a>
                  </li>
                  <li>
                    <a href="page-pricing2.php">Pricing Box 2</a>
                  </li>
                  <li>
                    <a href="page-princing_table.php">Pricing Mega Table</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Coming Soon</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-coming.php">Coming Soon Option 1</a>
                  </li>
                  <li>
                    <a href="page-coming2.php">Coming Soon Option 2</a>
                  </li>
                  <li>
                    <a href="page-coming3.php">Coming Soon Option 3</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">Email Templates</h3>
                <ul class="list-line">
                  <li>
                    <a href="page-email.php">Email Template 1</a>
                  </li>
                  <li>
                    <a href="page-email2.php">Email Template 2</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- row -->
            <h2 class="right-line right-line-white">Blog &amp; Portfolio</h2>
            <div class="row">
              <div class="col-md-6">
                <h3 class="color-primary mt-4">Blog</h3>
                <ul class="list-line">
                  <li>
                    <a href="blog-sidebar.php">Blog Sidebar 1</a>
                  </li>
                  <li>
                    <a href="blog-sidebar2.php">Blog Sidebar 2</a>
                  </li>
                  <li>
                    <a href="blog-masonry.php">Blog Masonry 1</a>
                  </li>
                  <li>
                    <a href="blog-masonry2.php">Blog Masonry 2</a>
                  </li>
                  <li>
                    <a href="blog-full.php">Blog Full Page 1</a>
                  </li>
                  <li>
                    <a href="blog-full2.php">Blog Full Page 2</a>
                  </li>
                  <li>
                    <a href="view-post.php">Blog Post 1</a>
                  </li>
                  <li>
                    <a href="view-post2.php">Blog Post 2</a>
                  </li>
                </ul>
                <h3 class="color-primary mt-4">E-Commerce</h3>
                <ul class="list-line">
                  <li>
                    <a href="ecommerce-filters.php">E-Commerce Sidebar</a>
                  </li>
                  <li>
                    <a href="ecommerce-filters-full.php">E-Commerce Sidebar Full</a>
                  </li>
                  <li>
                    <a href="ecommerce-filters-full2.php">E-Commerce Topbar Full</a>
                  </li>
                  <li>
                    <a href="ecommerce-item.php">E-Commerce Item</a>
                  </li>
                  <li>
                    <a href="ecommerce-cart.php">E-Commerce Cart</a>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <h3 class="color-primary mt-4">Portfolio</h3>
                <ul class="list-line">
                  <li>
                    <a href="portfolio-filters_sidebar.php">Portfolio Sidebar Filters</a>
                  </li>
                  <li>
                    <a href="portfolio-filters_topbar.php">Portfolio Topbar Filters</a>
                  </li>
                  <li>
                    <a href="portfolio-filters_sidebar_fluid.php">Portfolio Sidebar Fluid</a>
                  </li>
                  <li>
                    <a href="portfolio-filters_topbar_fluid.php">Portfolio Topbar Fluid</a>
                  </li>
                  <li>
                    <a href="portfolio-cards.php">Porfolio Cards</a>
                  </li>
                  <li>
                    <a href="portfolio-masonry.php">Porfolio Masonry</a>
                  </li>
                  <li>
                    <a href="portfolio-item.php">Portfolio Item 1</a>
                  </li>
                  <li>
                    <a href="portfolio-item2.php">Portfolio Item 2</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- row -->
          </div>
        </div>
      </div>
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>
  </body>
</html>
