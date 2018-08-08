<nav class="navbar navbar-expand-md  navbar-static ms-navbar ms-navbar-primary navbar-mode stay-on-top-navbar">
  <div class="container container-full">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?=$router->pathFor('home')?>">
        <!-- <img src="assets/img/default_pfp.png" alt=""> -->
        <span class="ms-logo ms-logo-sm">KC</span>
        <span class="ms-title">Kode
          <strong>Cental</strong>
        </span>
      </a>
    </div>
    <div class="collapse navbar-collapse" id="ms-navbar">
      <ul class="navbar-nav">
        <?php $c_user = \User::current();?>
        <?php if($c_user != null) { ?>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-7" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="page">Account
            <i class="zmdi zmdi-chevron-down"></i>
          </a>

          <ul class="dropdown-menu">

            <li>
              <a class="dropdown-item dropdown-link" href="<?=$router->pathFor('user-profile', ['username'=>$c_user->getUsername()])?>">Profile</a>
            </li>

            <li>
              <a class="dropdown-item dropdown-link" href="<?=$router->pathFor('user-favorites')?>">Favorites</a>
            </li>

            <li>
              <a class="dropdown-item dropdown-link refresh-logout" href="<?=$router->pathFor('user-logout')?>">Log Out</a>
            </li>

          </ul>

        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a href="<?=$router->pathFor('user-login-form')?>" class="nav-link">Log in</a>
        </li>
      <?php } ?>
        <?php if($c_user != null && $c_user->isSuper()) { ?>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-7" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="page">Posts
            <i class="zmdi zmdi-chevron-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item dropdown-link" href="<?=$router->pathFor('user-posts')?>">My posts</a>
            </li>
            <li>
              <a class="dropdown-item dropdown-link" href="<?=$router->pathFor('create-post')?>">Create New</a>
            </li>

          </ul>
        </li>
      <?php } ?>
      
        <li class="nav-item">
          <a href="#" class="nav-link">All Pages
          </a>
        </li>
      </ul>
    </div>
    <a href="javascript:void(0)" class="ms-toggle-left btn-navbar-menu">
      <i class="zmdi zmdi-menu"></i>
    </a>
  </div>
  <!-- container -->
</nav>
