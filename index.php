<?php
date_default_timezone_set('America/Los_Angeles');
require 'vendor/autoload.php';
// echo "hello";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// $log = new Logger('name');
// $log->pushHandler(new StreamHandler('app.txt', Logger::WARNING));
// $log->addWarning('Foo');

$app = new \Slim\App;

$app->get('/', function(){
  echo "Hello, this is the homepage.";
});

$app->get('/contact', function(){
  echo "Feel free to contact us.";
});

$app->run();

?>
