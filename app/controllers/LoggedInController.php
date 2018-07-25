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
        // show view to create a new post
        $app->get('/create-post', function ($request, $response, $args) {
            return $this->view->render(
            $response,
            'create-and-edit-post.php',
            ['router'=>$this->router, 'user'=>\User::current(), 'all_categories'=>\CategoryQuery::create()]
        );
        })->setName('create-post');

        // post information coming in, new post is being created
        // TODO: validate post
        $app->post('/create-post', function ($request, $response, $args) {
            $post = \Post::fromPostRequest($request->getParsedBody());
            $post->save();
            return $response->withJson(['success'=>true,
            'redirect'=>$this->router->pathFor('view-post', ['hyperlink'=>$post->getHyperlink()])]);
        });
    }

    public function editPost($app)
    {
        // show view to edit a post
        $app->get('/edit-post/{hyperlink}', function ($request, $response, $args) {
            $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);
            $user = \User::current();
            if ($post == null || $post->getUser() != $user) {
                // invalid post, or trying to edit something not yours, 404
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            return $this->view->render(
              $response,
                'create-and-edit-post.php',
              ['router'=>$this->router,
              'user'=>$user,
              'all_categories'=>\CategoryQuery::create(),
              'post_categories'=>$post->getCategories(),
              'post'=>$post]
            );
        })->setName('edit-post');

        // post information coming in, post is being edited
        // TODO: validate post
        $app->post('/edit-post/{hyperlink}', function ($request, $response, $args) {
            $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);

            if ($post == null || $post->getUser() != \User::current()) {
                return $reponse->withJson(['success'=>false]);
            }
            $post = \Post::fromPostRequest($request->getParsedBody(), $post);
            $post->save();
            return $response->withJson(['success'=>true, 'text'=>'Post successfully updated!']);
        });
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
            $controller->editPost($app);
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
