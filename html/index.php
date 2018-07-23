<?php
use App\Mail\Mail;
use App\Controllers\LoggedInController;

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

$app->get('/test', function ($request, $response, $args) {
    echo "test";
    $user = new \User();
    $user->setJoinDate(getCurrentDate());
    print_r($user->toArray());
    return null;
})->setName('home');

App\Controllers\LoggedInController::setUpRouting($app);
App\Controllers\LoggedOutController::setUpRouting($app);

$app->run();
