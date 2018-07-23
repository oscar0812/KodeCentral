<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

// User needs to be signed in to access this group
class LoggedInController
{
    public function createPost($app)
    {
        $app->get('/create-post', function ($request, $response, $args) {
            return $this->view->render(
            $response,
            'create-post.php',
            ['router'=>$this->router, 'post'=>$post]
        );
        })->setName('create-post');
    }

    public function logOut($app)
    {
        $app->get('/logout', function ($request, $response, $args) {
            \User::logOut();
            return $response->withRedirect($this->router->pathFor('user-login-form'));
        })->setName('user-logout');
    }

    public static function setUpRouting($app)
    {
        $controller = new LoggedInController();
        $app->group('', function () use ($controller, $app) {
            $controller->createPost($app);
            $controller->logOut($app);
        })->add(function ($request, $response, $next) {
            if (\User::current() != null) {
                // signed in, show them what they want
                return $next($request, $response);
            } else {
                // not signed in, redirect to home page
                return $response->withRedirect($this->router->pathFor('user-login-form'));
            }
        });
    }
}
