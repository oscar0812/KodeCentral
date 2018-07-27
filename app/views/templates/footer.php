<?php if(!isset($home)) $home = '';
      $latest_posts = \PostQuery::create()->orderByPostedDate('desc')->limit(3)->find();?>
<aside class="ms-footbar">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 ms-footer-col">
        <div class="ms-footbar-block">
          <h3 class="ms-footbar-title">Sitemap</h3>
          <ul class="list-unstyled ms-icon-list three_cols">
            <li>
              <a href="<?=$router->pathFor('home')?>">
                <i class="zmdi zmdi-home"></i> Home</a>
            </li>
            <li>
              <a href="<?=$router->pathFor('about-us')?>">
                <i class="zmdi zmdi-favorite-outline"></i> About Us</a>
            </li>
            <li>
              <a href="<?=$router->pathFor('our-team')?>">
                <i class="zmdi zmdi-accounts"></i> Our Team</a>
            </li>
            <li>
              <a href="<?=$router->pathFor('faq')?>">
                <i class="zmdi zmdi-help"></i> FAQ</a>
            </li>
            <li>
              <a href="<?=$router->pathFor('user-login-form')?>">
                <i class="zmdi zmdi-lock"></i> Login</a>
            </li>
            <li>
              <a href="<?=$router->pathFor('contact-us')?>">
                <i class="zmdi zmdi-email"></i> Contact</a>
            </li>
            <li>
              <a href="<?=$router->pathFor('all-pages')?>">
                <i class="zmdi zmdi-link"></i> All Pages</a>
            </li>
          </ul>
        </div>
        <div class="ms-footbar-block">
          <h3 class="ms-footbar-title">Subscribe</h3>
          <p class="">Lorem ipsum Amet fugiat elit nisi anim mollit minim labore ut esse Duis ullamco ad dolor veniam velit.</p>
          <form>
            <div class="form-group label-floating mt-2 mb-1">
              <div class="input-group ms-input-subscribe">
                <label class="control-label" for="ms-subscribe">
                  <i class="zmdi zmdi-email"></i> Email Adress</label>
                <input type="email" id="ms-subscribe" class="form-control"> </div>
            </div>
            <button class="ms-subscribre-btn" type="button">Subscribe</button>
          </form>
        </div>
      </div>
      <div class="col-lg-5 col-md-7 ms-footer-col ms-footer-alt-color">
        <div class="ms-footbar-block">
          <h3 class="ms-footbar-title text-center mb-2">Last Posts</h3>
          <div class="ms-footer-media">

            <?php foreach ($latest_posts as $post) { ?>
              <!-- media block -->
              <div class="media">
                <div class="media-left media-middle">
                  <a href="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>">
                    <img class="media-object media-object-circle" src="<?=$home?>assets/img/demo/p75.jpg" alt="..."> </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading">
                    <a href="<?=$router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])?>">
                      <?=$post->getTitle()?></a>
                  </h4>
                  <div class="media-footer">
                    <span><?=$post->getSummary()?></span><br>
                    <span>
                      <i class="zmdi zmdi-time color-info-light"></i> <?=$post->getPostedDate()->format('F d, Y')?></span>
                    <span>
                      <i class="zmdi zmdi-folder-outline color-warning-light"></i>
                      <?=$post->getCategories()[0]->getName()?>
                    </span>
                  </div>
                </div>
              </div>
              <!-- /media block -->
            <?php } ?>

          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-5 ms-footer-col ms-footer-text-right">
        <div class="ms-footbar-block">
          <div class="ms-footbar-title">
            <span class="ms-logo ms-logo-white ms-logo-sm mr-1">M</span>
            <h3 class="no-m ms-site-title">Kode
              <span>Central</span>
            </h3>
          </div>
          <address class="no-mb">
            <p>
              <i class="color-danger-light zmdi zmdi-pin mr-1"></i> 795 Folsom Ave, Suite 600</p>
            <p>
              <i class="color-warning-light zmdi zmdi-map mr-1"></i> San Francisco, CA 94107</p>
            <p>
              <i class="color-info-light zmdi zmdi-email mr-1"></i>
              <a href="mailto:joe@example.com">example@domain.com</a>
            </p>
            <p>
              <i class="color-royal-light zmdi zmdi-phone mr-1"></i>+34 123 456 7890 </p>
            <p>
              <i class="color-success-light fa fa-fax mr-1"></i>+34 123 456 7890 </p>
          </address>
        </div>
        <div class="ms-footbar-block">
          <h3 class="ms-footbar-title">Social Media</h3>
          <div class="ms-footbar-social">
            <a href="javascript:void(0)" class="btn-circle btn-facebook">
              <i class="zmdi zmdi-facebook"></i>
            </a>
            <a href="javascript:void(0)" class="btn-circle btn-twitter">
              <i class="zmdi zmdi-twitter"></i>
            </a>
            <a href="javascript:void(0)" class="btn-circle btn-youtube">
              <i class="zmdi zmdi-youtube-play"></i>
            </a>
            <br>
            <a href="javascript:void(0)" class="btn-circle btn-google">
              <i class="zmdi zmdi-google"></i>
            </a>
            <a href="javascript:void(0)" class="btn-circle btn-instagram">
              <i class="zmdi zmdi-instagram"></i>
            </a>
            <a href="javascript:void(0)" class="btn-circle btn-github">
              <i class="zmdi zmdi-github"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</aside>
<footer class="ms-footer">
  <div class="container">
    <p>Copyright &copy; Kode Central 2018</p>
  </div>
</footer>
<div class="btn-back-top">
  <a href="#" data-scroll id="back-top" class="btn-circle btn-circle-primary btn-circle-sm btn-circle-raised ">
    <i class="zmdi zmdi-long-arrow-up"></i>
  </a>
</div>
