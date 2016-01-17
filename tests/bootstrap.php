<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

$vendorPath = realpath(dirname(__FILE__) . '/../vendor/');
$libPath    = realpath(dirname(__FILE__) . '/../lib/');
$testsPath  = realpath(dirname(__FILE__) . '/../tests/');

$loader = require $vendorPath . '/autoload.php';
$loader->add('NurseTests\\', $testsPath);
$loader->add('Dummy\\', $testsPath);
