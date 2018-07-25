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
                ['router'=>$this->router,
                'posts'=>\PostQuery::create()->find(),
                'all_categories'=>\CategoryQuery::create()->find()]
            );
        })->setName('home');
    }

    public function post($app)
    {
        $app->get('/post/{hyperlink}', function ($request, $response, $args) {
            $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);

            if ($post == null) {
                // invalid post, throw 404
                throw new \Slim\Exception\NotFoundException($request, $response);
            }
            return $this->view->render(
                $response, 'view-post.php',
                ['router'=>$this->router, 'post'=>$post, 'user'=>\User::current()]
            );
        })->setName('view-post');
    }

    public function profile($app)
    {
        // when visiting someones profile
        $app->get('/profile/{username}', function ($request, $response, $args) {
            $user = \UserQuery::create()->findOneByUsername($args['username']);

            if($user == null){
              throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $current = \User::current();
            $visiting = true;
            if ($current != null && $current->getId() == $user->getId()) {
                $visiting = false;
            }
            return $this->view->render(
              $response, 'page-profile.php',
              ['router'=>$this->router, 'user'=>$user, 'visiting'=>$visiting]
          );
        })->setName('user-profile');
    }

    public static function setUpRouting($app)
    {
        $controller = new AllController();
        $controller->home($app);
        $controller->post($app);
        $controller->profile($app);
    }
}
