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

$app->post('/contact', function() use($app) {
  $sender = $app->request->post('sender');
  $email = $app->request->post('email');
  $message = $app->request->post('message');
  if(!empty('sender') && !empty('email') && !empty('message')) {
    $cleanSender = filter_var($sender, FILTER_SANITIZE_STRING);
    $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $cleanMessage = filter_var($message, FILTER_SANITIZE_STRING);
  } else {
    // feedback to user about an error
    $app->redirect('/contact');
  }
})->name('contact');

$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail');
$mailer = \Swift_Mailer::newInstance($transport);

$app->run();

