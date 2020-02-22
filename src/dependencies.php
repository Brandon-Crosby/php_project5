<?php
// DIC configuration
// Get container
$container = $app->getContainer();

// Register component on container (your view or renderer)
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path']);
  return $view;
};

//$container = $app->getContainer();

//view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c->get('settings')['db'];
    $pdo = new PDO($db['driver'].':'.$db['database']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
$container['post'] = function ($c) {
    return new App\Post($c->get('db'));
};
$container['comments'] = function ($c) {
    return new App\Comments($c->get('db'));
};
