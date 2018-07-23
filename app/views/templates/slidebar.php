<?php $user = \User::current()?>
<div class="ms-slidebar sb-slidebar sb-left sb-style-overlay" id="ms-slidebar">
  <div class="sb-slidebar-container">
    <header class="ms-slidebar-header">
      <div class="ms-slidebar-login">
        <?php $path = ($user == null)?'user-login-form': 'user-profile';
              $name = ($user == null)?'Account': $user->getUsername()?>
        <a href="<?=$router->pathFor($path)?>" class="withripple">
          <i class="zmdi zmdi-account"></i> <?=$name?></a>

        <?php if($user != null) { ?>
          <a href="<?=$router->pathFor('user-logout')?>" class="withripple">
            <i class="zmdi zmdi-book"></i> Log out</a>
        <?php } ?>
      </div>
      <div class="ms-slidebar-title">
        <form class="search-form">
          <input id="search-box-slidebar" type="text" class="search-input" placeholder="Search..." name="q" />
          <label for="search-box-slidebar">
            <i class="zmdi zmdi-search"></i>
          </label>
        </form>
        <div class="ms-slidebar-t">
          <span class="ms-logo ms-logo-sm">KC</span>
          <h3>Kode
            <span>Central</span>
          </h3>
        </div>
      </div>
    </header>
    <ul class="ms-slidebar-menu" id="slidebar-menu" role="tablist" aria-multiselectable="true">
      <li>
        <a class="link" href="<?=$router->pathFor('home')?>">
          <i class="zmdi zmdi-home"></i> Home</a>
      </li>
      <li>
        <a class="link" href="page-all.php">
          <i class="zmdi zmdi-star"></i> Favorites</a>
      </li>
      <li>
        <a class="link" href="page-all.php">
          <i class="zmdi zmdi-email"></i> Contact Us</a>
      </li>
      <li>
        <a class="link" href="page-all.php">
          <i class="zmdi zmdi-favorite"></i> About Us</a>
      </li>
      <li>
        <a class="link" href="page-all.php">
          <i class="zmdi zmdi-link"></i> All Pages</a>
      </li>
    </ul>

  </div>
</div>
