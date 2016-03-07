<?php
require 'vendor/autoload.php';
echo "hello";
$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.txt', Monolog\Logger::WARNING));
$log->addWarning('Foo');
?>
