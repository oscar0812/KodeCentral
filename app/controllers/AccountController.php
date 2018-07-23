<?php
// a controller for the /account route since its alot of code
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

class AccountController
{
    public static function setUpRouting($app)
    {
        $app->group('/account', function () use ($app) {
          // show the login, register, forgot password forms
            $app->get('', function ($request, $response, $args) {
                return $this->view->render(
                $response,
                'page-login_register.php',
                ['router'=>$this->router]
            );
            })->setName('user-login-form');

            $app->post('/info', function ($request, $response, $args) {
                // to check if email and username are available
                $post = $request->getParsedBody();
                if (isset($post['email'])) {
                    $info = \UserQuery::create()
                  ->findOneByEmail($request->getParsedBody()['email']);
                } elseif ($post['username']) {
                    $info = \UserQuery::create()
                  ->findOneByUsername($request->getParsedBody()['username']);
                }

                echo ($info== null)?"true":"false";
            });

            // info is complete, now check if correct (TODO: make sure to use validation)
            $app->post('/credentials', function ($request, $response, $args) {
                $post = $request->getParsedBody();
                if (isset($post['Login'])) {
                    // trying to log in
                    $user = \UserQuery::create()->findOneByUsername($post['Login']['Username']);

                    if ($user == null || !$user->verifyPassword($post['Login']['Password'])) {
                        return $response->withJSON(['success'=>false]);
                    }
                    $user->logIn();
                    return $response->withJSON(['success'=>true,
                    'redirect_link'=>$this->router->pathFor('user-profile')]);
                } elseif (isset($post['Register'])) {
                    // trying to make new account
                    $user = new \User();
                    foreach ($post['Register'] as $key => $value) {
                        $user->setByName($key, $value);
                    }
                    $user->setJoinDate(getCurrentDate());
                    // validate here
                    $user->save();
                    return $response->withJSON(['success'=>true]);
                } elseif (isset($post['Forgot'])) {
                    // trying to recover password
                    return $response->withJSON(['success'=>false]);
                } else {
                    // other, not valid
                    return $response->withJSON(['success'=>false]);
                }
            })->setName('user-credentials');
        })->add(function ($request, $response, $next) {
            if (\User::current() == null) {
                // not signed in, so show them forms to sign in
                return $next($request, $response);
            } else {
                // already signed in, redirect to profile
                return $response->withRedirect($this->router->pathFor('user-profile'));
            }
        });
    }
}
