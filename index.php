<?php
require 'vendor/autoload.php';
date_default_timezone_set('America/Los_Angeles');

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig(),
  )
);
$app->add(new \Slim\Middleware\SessionCookie());

$view = $app->view();
$view->parserOptions = array(
  'debug' => TRUE,
);

// https://github.com/slimphp/Slim-Views
$view->parserExtensions = array(
  new \Slim\Views\TwigExtension(),
);

$app->get('/', function () use ($app) {
    $app->render('about.twig'); // <-- SUCCESS
  }
)->name('home');

$app->get('/contact', function () use ($app) {
    $app->render('contact.twig'); // <-- SUCCESS
  }
)->name('contact');

$app->post('/contact', function () use ($app) {
    $sender = $app->request->post('sender');
    $email = $app->request->post('email');
    $message = $app->request->post('message');
  // why does this condition never fail?
  if (!empty('sender') && !empty('email') && !empty('message')) {
      $cleanSender = filter_var($sender, FILTER_SANITIZE_STRING);
      $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
      $cleanMessage = filter_var($message, FILTER_SANITIZE_STRING);
    }
    else {
      // http://docs.slimframework.com/flash/overview/
      $app->flash('error', 'All fields are required');
      $app->redirect('/contact');
    }
    $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
    $mailer = \Swift_Mailer::newInstance($transport);

    $theMessage = \Swift_Message::newInstance();
    $theMessage->setSubject('Email from our website');
    $theMessage->setFrom(
      array(
        $cleanEmail => $cleanSender,
      )
    );
    $theMessage->setTo('firelf@juno.com');
    $theMessage->setBody($cleanMessage);

    $result = $mailer->send($theMessage);
    if ($result > 0) {
      // feedback to user re: thank you
      $app->flash(
        'contact',
        'Thank you for attempting to contact Waldo. He may be awhile responding seeing as he is dead.'
      );
      $app->redirect('/composer');
    }
    else {
      // feedback to use re: failure
      // log error
      $app->redirect('/contact');
    }

  }
)->name('contact');

$app->run();

