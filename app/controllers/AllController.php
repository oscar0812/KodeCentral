<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

// All the routes here can be seen if logged in or out, doesnt matter
class AllController
{
    public function home($app)
    {
        $app->get('/', function ($request, $response, $args) {
            return $this->view->render(
                $response,
                'home.php',
                ['router'=>$this->router, 'on_home' => true,
                'posts'=>\PostQuery::create()->orderByPostedDate('desc')->find(),
                'all_libraries'=>\LibraryQuery::create()->find(),
                'user'=>\User::current()]
            );
        })->setName('home');
    }

    public function library($app)
    {
        // the "library" groups posts together (useful for tutorials that need
        // more than one post to explain well)
        $app->get('/lib/{name}', function ($request, $response, $args) {
            $lib = \LibraryQuery::create()->findOneByName($args['name']);

            if ($lib == null) {
                // invalid library, throw 404
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            return $this->view->render(
              $response,
              'post-list.php',
              ['router'=>$this->router,
              'posts'=>\PostQuery::create()->  orderByLibraryIndex()->findByLibrary($lib),
              'title'=>'Library: '.$lib->getName()]
          );
        })->setName('library');
    }

    public function search($app)
    {
        $app->get('/search', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'search.php',
                ['router'=>$this->router]
            );
        })->setName('search');
    }

    public function contactUs($app)
    {
        $app->get('/contact', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'contact.php',
                ['router'=>$this->router]
            );
        })->setName('contact-us');

        // trying to send an email to us
        $app->post('/contact', function ($request, $response, $args) {
            $params = $request->getParsedBody();

            if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL) ||
                  $params['message'] == "" || $params['message'] == null) {
                return $response->withJson(['success'=>false, 'msg'=>'Invalid data']);
            }

            $arr = \App\Utils\Mail::contactUs($params['email'], $params['message']);
            return $response->withJson($arr);
        });
    }

    public function aboutUs($app)
    {
        $app->get('/about-us', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'about-us.php',
                ['router'=>$this->router]
            );
        })->setName('about-us');
    }

    public function faq($app)
    {
        $app->get('/faq', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'faq.php',
                ['router'=>$this->router]
            );
        })->setName('faq');
    }

    public function appPost($app)
    {
        $app->get('/app', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'home-app.php',
                ['router'=>$this->router]
            );
        })->setName('app');
    }

    public function allPages($app)
    {
        $app->get('/all-pages', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'all-pages.php',
                ['router'=>$this->router, 'user'=>\User::current()]
            );
        })->setName('all-pages');
    }

    public function viewPost($app)
    {
        $app->get('/post/{hyperlink}', function ($request, $response, $args) {
            $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);

            if ($post == null) {
                // invalid post, throw 404
                throw new \Slim\Exception\NotFoundException($request, $response);
            }
            // show three related posts
            $r_p = \PostQuery::create()->limit(3)->find();

            // show comments for post (newest ones first)
            $comments = \CommentQuery::create()->
              filterByPost($post)->orderByPostedTime('desc');

            return $this->view->render(
                $response,
                'view-post.php',
                ['router'=>$this->router, 'post'=>$post, 'comments'=>$comments,
                'related_posts'=>$r_p , 'user'=>\User::current(),
                'lib_name'=>$post->getLibrary()->getName()]
            );
        })->setName('view-post');
    }

    public function profile($app)
    {
        // when visiting someones profile
        $app->get('/profile/{username}', function ($request, $response, $args) {
            $user = \UserQuery::create()->findOneByUsername($args['username']);

            if ($user == null) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $current = \User::current();
            $visiting = true;
            if ($current != null && $current->getId() == $user->getId()) {
                $visiting = false;
            }

            return $this->view->render(
              $response,
                'profile.php',
              ['router'=>$this->router, 'user'=>$user, 'visiting'=>$visiting]
          );
        })->setName('user-profile');
    }

    public static function setUpRouting($app)
    {
        $controller = new AllController();
        $controller->home($app);
        $controller->library($app);
        $controller->search($app);
        $controller->contactUs($app);
        $controller->aboutUs($app);
        $controller->faq($app);
        $controller->appPost($app);
        $controller->allPages($app);

        $controller->viewPost($app);
        $controller->profile($app);
    }
}
