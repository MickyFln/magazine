<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/config');
$dotenv->load();

$paths = array(__DIR__ . '/doctrine');
$isDevMode = getenv('environment') === 'local';

// the connection configuration
$dbParams = array(
  'driver'   => 'pdo_mysql',
  'user'     => getenv('DB_USERNAME'),
  'password' => getenv('DB_PASSWORD'),
  'dbname'   => getenv('DB_DATABASE'),
);
