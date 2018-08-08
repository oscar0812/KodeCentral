<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

// User needs to be signed in to access this group
class LoggedInController
{
    public function favorites($app)
    {
        $app->get('/favorites', function ($request, $response, $args) {
            $user = \User::current();
            return $this->view->render(
          $response,
            'post-list.php',
            ['router'=>$this->router, 'user'=>$user,
            'posts'=>$user->getFavoritePosts(), 'title'=>'Your favorites',
            'favorites'=>true
          ]
        );
        })->setName('user-favorites');

        // trying to remove or add a post from favorites
        $app->post('/favorites', function ($request, $response, $args) {
            $user = \User::current();
            $params = $request->getParsedBody();

            $post = \PostQuery::create()->findOneByHyperlink($params['post']);
            if ($post == null) {
                return $response->withJson(['success'=>false]);
            }

            if ($user->hasPostInFavorites($post)) {
                $user->removeFavoritePost($post);
                $user->save();
                return $response->withJson(['success'=>true, 'status'=>'removed']);
            } else {
                $user->addFavoritePost($post);
                $user->save();
                return $response->withJson(['success'=>true, 'status'=>'added']);
            }
        });
    }

    public function createPost($app)
    {
        // show view to create a new post
        $app->get('/create-post', function ($request, $response, $args) {
            return $this->view->render(
            $response,
            'create-and-edit-post.php',
            ['router'=>$this->router, 'user'=>\User::current(),
            'all_libraries'=>\LibraryQuery::create()]
        );
        })->setName('create-post');

        // new lib info coming in, creating new library
        $app->post('/create-post-lib', function ($request, $response, $args) {
            $params = $request->getParsedBody();
            if (!isset($params['lib-name'])) {
                $response->withJson(['success'=>false, 'msg'=>'Invalid data']);
            }
            $lib = new \Library();
            $lib->setName($params['lib-name']);

            if (!$lib->validate()) {
                $response->withJson(['success'=>false, 'msg'=>'Invalid data']);
            }

            $lib->save();

            return $response->withJson(['success'=>true, 'msg'=>$lib->getName()]);
        })->setName('create-lib');

        // get all the posts for a library (to figure out the position)
        $app->post('/ajax-lib-posts', function ($request, $response, $args) {
            $params = $request->getParsedBody();
            $lib = \LibraryQuery::create()->findOneByName($params['library']);
            if ($lib == null) {
                return $response->withJson([]);
            }

            $posts = \PostQuery::create()->orderByLibraryIndex()->findByLibrary($lib)->toArray();

            // only return the title for security purposes
            return $response->withJson(array_column($posts, 'Title', 'Hyperlink'));
        })->setName('ajax-lib-posts');

        // post information coming in, new post is being created
        $app->post('/create-post', function ($request, $response, $args) {
            $params = $request->getParsedBody();
            $post = \Post::fromPostRequest($params);
            if (!$post->validate()) {
                return $response->withJSON(['success'=>false, 'text'=>'Error!']);
            }
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
            if ($post == null || $post->getPostedByUser() != $user) {
                // invalid post, or trying to edit something not yours, 404
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            return $this->view->render(
              $response,
                'create-and-edit-post.php',
              ['router'=>$this->router,
              'user'=>$user,
              'all_libraries'=>\LibraryQuery::create(),
              'post'=>$post]
            );
        })->setName('edit-post');

        // post information coming in, post is being edited
        $app->post('/edit-post/{hyperlink}', function ($request, $response, $args) {
            $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);

            if ($post == null || $post->getPostedByUser() != \User::current()) {
                return $response->withJson(['success'=>false]);
            }
            $link = $post->getHyperlink();
            $post = \Post::fromPostRequest($request->getParsedBody(), $post);
            $post->setText($request->getParsedBody()['text']);

            if (!$post->validate()) {
                return $response->withJSON(['success'=>false, 'text'=>'Error!']);
            }

            $post->save();
            $json = ['success'=>true, 'text'=>'Post successfully updated!'];
            if ($post->getHyperlink() != $link) {
                // link changed, redirect to avoid errors
                $json['redirect'] =
                $this->router->pathFor('edit-post', ['hyperlink'=>$post->getHyperlink()]);
            }

            return $response->withJson($json);
        });
    }

    // show a list of the posts the current user has submitted
    public function userPosts($app)
    {
        $app->get('/my-posts', function ($request, $response, $args) {
            $user = \User::current();
            $posts = \PostQuery::create()->filterByPostedByUser($user)->orderByPostedDate('desc')->find();
            return $this->view->render(
            $response,
              'post-list.php',
              ['router'=>$this->router, 'user'=>$user, 'posts'=>$posts, 'title'=>'Your posts']
          );
        })->setName('user-posts');
    }

    public function postComment($app)
    {
        // when a user is trying to public a comment for a blog post
        $app->post('/post/comment/{hyperlink}', function ($request, $response, $args) {
            $text = $request->getParsedBody()['text'];

            $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);

            if ($post == null || $text == "" || $text == null) {
                // post doesnt exist, or blank comment
                return $response->withJson(['success'=>false]);
            }

            $user = \User::current();
            $user_link = $this->router->pathFor('user-profile', ['username'=>$user->getUsername()]);

            $comment = new \Comment();
            $comment->setText($text);
            $comment->setUser($user);
            $comment->setPost($post);
            $comment->setPostedTime(getCurrentDateTime());
            $comment->save();

            return $response->withJson(['success'=>true,
            'text'=>$comment->getText()]);
        })->setName('post-comment');
    }

    // user is trying to change profile information
    public function changeProfileInfo($app)
    {
        $app->post('/profile-info', function ($request, $response) {
            $params = $request->getParsedBody();
            $user = \User::current();

            $arr = array();

            if ($params['file-text'] != '') {
                // call ImageUpload which returns an array with flags and data
                $arr = \App\Utils\ImageUpload::uploadPfp($user, $this->router->pathFor('home'));

                if ($arr['success']) {
                    // successfully uploaded image, so set the path as the
                    // users pfp url in db
                    $user->setProfilePicture($arr['path']);
                    $user->save();
                } else {
                    // an error occured, return the array
                    return $response->withJson($arr);
                }
            }

            if ($params['bio'] =='') {
                return $response->withJson(['success'=>false, 'msg'=>'Bio can\'t be empty']);
            }

            $user->setBio($params['bio']);
            $user->save();
            $arr['success'] = true;
            $arr['bio'] = $user->getBio();

            return $response->withJson($arr);
        })->setName('user-profile-info');
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
        // 2 middleware, first has all ability, 2nd can only post comments and
        // log out
        $controller = new LoggedInController();
        $app->group('', function () use ($controller, $app) {
            $controller->favorites($app);
            $controller->createPost($app);
            $controller->editPost($app);
            $controller->userPosts($app);
        })->add(function ($request, $response, $next) {
            $user = \User::current();
            if ($user != null && $user->isSuper()) {
                // signed in and super user, show them what they want
                return $next($request, $response);
            } else {
                // not signed in, redirect to home page
                return $response->withRedirect($this->router->pathFor('user-login-form'));
            }
        });

        $app->group('', function () use ($controller, $app) {
            $controller->postComment($app);
            $controller->logOut($app);
            $controller->changeProfileInfo($app);
        })->add(function ($request, $response, $next) {
            $user = \User::current();
            if ($user != null) {
                // signed in, show them what they want
                return $next($request, $response);
            } else {
                // not signed in, redirect to home page
                return $response->withRedirect($this->router->pathFor('user-login-form'));
            }
        });
    }
}
