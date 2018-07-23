<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

// User needs to be signed in to access this group
class LoggedInController
{
    public function profile($app)
    {
        $app->get('/profile', function ($request, $response, $args) {
            return $this->view->render(
              $response,
                'page-profile.php',
              ['router'=>$this->router, 'user'=>\User::current()]
          );
        })->setName('user-profile');
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
            $controller->profile($app);
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
