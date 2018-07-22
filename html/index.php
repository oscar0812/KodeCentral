<?php
use App\Mail\Mail;

require '../vendor/autoload.php';

// adding an external config file
require '../config.php';
require '../data/generated-conf/config.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("../app/views/");

// if url is not found (404)
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['view']->render(
            $response->withStatus(404),
            'page-404.php',
        ['router' => $c->router]
        );
    };
};

$app->get('/', function ($request, $response, $args) {
    return $this->view->render(
        $response,
        'home.php',
        ['router'=>$this->router, 'posts'=>\PostQuery::create()->find(), 'categories'=>\CategoryQuery::create()->find()]
    );
})->setName('home');

$app->get('/post-{hyperlink}', function ($request, $response, $args) {
    $post = \PostQuery::create()->findOneByHyperlink($args['hyperlink']);

    if ($post == null) {
        // invalid post, throw 404
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
    return $this->view->render(
        $response,
        'blog-post.php',
        ['router'=>$this->router, 'post'=>$post]
    );
})->setName('blog-post');

$app->group('/account', function () use ($app) {
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
            return $response->withJSON(['success1'=>false]);
        } elseif (isset($post['Register'])) {
            // trying to make new account
            $user = new \User();
            foreach ($post['Register'] as $key => $value) {
                $user->setByName($key, $value);
            }
            // validate here
            //$user->save();
            return $response->withJSON(['success'=>true]);
        } elseif (isset($post['Forgot'])) {
            // trying to recover password
            return $response->withJSON(['success3'=>false]);
        } else {
            return $response->withJSON(['success4'=>false]);
        }
    })->setName('user-credentials');
});

$app->get('/profile', function ($request, $response, $args) {
    return $this->view->render(
        $response,
        'page-profile.php',
        ['router'=>$this->router]
    );
})->setName('user-profile');


$app->run();
