<?php
require 'vendor/autoload.php';
date_default_timezone_set('America/Los_Angeles');

$app = new \Slim\Slim( array (
  'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->parserOptions = array(
  'debug' => true
);

// https://github.com/slimphp/Slim-Views
$view->parserExtensions = array(
  new \Slim\Views\TwigExtension()
);

$app->get('/', function() use($app) {
  $app->render('about.twig'); // <-- SUCCESS
})->name('home');

$app->get('/contact', function() use($app) {
  $app->render('contact.twig'); // <-- SUCCESS
})->name('contact');

$app->run();

