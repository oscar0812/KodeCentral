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
        return $c['view']->render($response->withStatus(404), 'page-404.php',
        ['router' => $c->router, 'home'=>$c->router->pathFor('home')]);
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

$app->get('/login', function ($request, $response, $args) {
    return $this->view->render(
        $response,'page-login_register.php',['router'=>$this->router]);
})->setName('user-login');

$app->get('/profile', function ($request, $response, $args) {
    return $this->view->render(
        $response,'page-profile.php',['router'=>$this->router]);
})->setName('user-profile');

$router = $app->getContainer()->router;

// to avoid errors when fetching files from the html folder,
// routes will try to look at html/index.php/ which is a valid url,
// but not a valid directory
define('$home', replaceLast('index.php/', '', $router->pathFor('home')));

$app->run();
