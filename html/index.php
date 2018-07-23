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

$app->get('/test', function ($request, $response, $args) {
  return $this->view->render(
      $response,
      'test.php',
      ['router'=>$this->router]);
});

App\Controllers\AllController::setUpRouting($app);
App\Controllers\LoggedInController::setUpRouting($app);
App\Controllers\LoggedOutController::setUpRouting($app);

$app->run();
