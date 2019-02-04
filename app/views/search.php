<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Kode Central | Search</title>
    <meta name="description" content="Search our posts">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
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
      <div class="ms-hero-page-override ms-hero-img-city ms-hero-bg-royal">
        <div class="container">
          <div class="text-center">
            <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">Search post</span>
            </h1>
            <div class="mw-500 center-block animated fadeInUp">
              <input type="text" placeholder="Enter keyword here to search titles and main text.."
                value="<?=$text?>" class="form-control color-white" id="main-text">
              <button type="button" class="btn btn-raised btn-primary btn-block" id="search-button">
                <i class="zmdi zmdi-search"></i> <span>Search</span></button>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card card-hero animated slideInUp animation-delay-8 mb-6">
          <div class="card-body">
            <h2 class="right-line right-line-white">Results</h2>
            <!--results here -->
            <div class="card post-card mb-1 mix library-java-bot col-sm-12 invisible" data-url="" id="template">
                <table class="table table-responsive table-no-border vertical-center">
                  <tbody>
                    <tr>
                      <td style="width: 20%">
                        <h4 class="post-title">hi</h4>
                      </td>
                      <td style="width: 70%">
                        <h4 class="post-text">hi</h4>
                      </td>
                      <td style="width: 20%">
                        <span class="color-info post-date">August 07, 2018</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <div id="paste">

            </div>
          </div>
        </div>
      </div>
      <!-- /container -->
      <?php require_once('templates/footer.php')?>
    </div>
    <!-- ms-site-container -->
    <?php require_once('templates/slidebar.php')?>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script type="text/javascript">

      $(function() {
        button = $('#search-button');
        template = $('#template');
        paste = $('#paste');

        function goFetchPosts(searchThis) {
          if(searchThis == '') return;

          button.attr('disabled', true);
          paste.children().remove();
          button.find('span').text('Searching...');

          $.ajax({
            type: "POST",
            data: {
              text: searchThis
            },
            url: "",
            dataType: "json",
            success: function(data) {
              button.attr('disabled', false);
              button.find('span').text('Search');

              $.each(data, function(i, post){
                copy = template.clone().removeClass('invisible');
                copy.attr('data-url', post['Hyperlink']);
                copy.find('.post-title').text(post['Title']);
                copy.find('.post-text').text(post['Text']);
                copy.find('.post-date').text(post['PostedDate']);
                paste.prepend(copy);
              });
              
              // change url in case of reload
              beginning = [location.protocol, '//', location.host, location.pathname].join('');
              newUrl = beginning+"?text="+searchThis;
              window.history.pushState(null, '', newUrl);
            }
          });
        }

        searchThis = $('#main-text');
        goFetchPosts(searchThis.val());

        button.on('click', function(){
          goFetchPosts(searchThis.val());
        });

        // when enter is pressed, trigger the button click
        searchThis.on('keyup', function(e) {
          if (e.keyCode === 13) {
            button.click();
          }
        });

      });
    </script>
  </body>
</html>
