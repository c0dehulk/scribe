<?php
declare(strict_types = 1);

// Bootstrap the script.
ini_set('display_errors', '1');
error_reporting(E_ALL);
chdir(__DIR__ . '/..');
require 'vendor/autoload.php';

// Run the console application.
$app = new \Codehulk\PackageDocs\App();
$app->run();
