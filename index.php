<?php
require 'vendor/autoload.php';
date_default_timezone_set('America/Los_Angeles');

$app = new \Slim\Slim();

$app->get('/', function() use($app) {
  $app->render('index.html'); // <-- SUCCESS
});

$app->get('/contact', function() use($app) {
  $app->render('contact.html'); // <-- SUCCESS
});

$app->run();

