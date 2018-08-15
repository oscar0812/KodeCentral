<?php

use app\controllers\LoggedInController;

require '../vendor/autoload.php';

// adding an external config file
require '../config.php';

// to protect from fake urls
$url = url();
$url1= 'http://localhost/kode_central/html';
$url2 = 'https://kodecentral.com';
if (substr($url, 0, strlen($url1)) !== $url1 && substr($url, 0, strlen($url2)) !== $url2) {
    header('Location: '.'https://kodecentral.com');
    exit();
}

require '../data/generated-conf/config.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("../app/views/");

// if url is not found (404)
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['view']->render(
            $response->withStatus(404),
            '404.php',
        ['router' => $c->router]
        );
    };
};

$app->get('/test', function ($request, $response, $args) {
    return $this->view->render(
      $response,
      'test.php',
      ['router'=>$this->router]
  );
});

app\controllers\AllController::setUpRouting($app);
app\controllers\LoggedInController::setUpRouting($app);
app\controllers\LoggedOutController::setUpRouting($app);


$app->run();
