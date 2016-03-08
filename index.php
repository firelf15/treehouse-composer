<?php
date_default_timezone_set('America/Los_Angeles');
require 'vendor/autoload.php';
echo "hello";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('name');
$log->pushHandler(new StreamHandler('app.txt', Logger::WARNING));
$log->addWarning('Foo');
?>
