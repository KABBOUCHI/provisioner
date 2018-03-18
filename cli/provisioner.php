#!/usr/bin/env php
<?php
/**
 * Load correct autoloader depending on install location.
 */
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    require __DIR__ . '/../../../autoload.php';
}

use Illuminate\Container\Container;

use Silly\Application;

Container::setInstance(new Container);

$version = '0.0.1';

$app = new Application('Provisioner', $version);

$app->command('install [--with-redis]', function ($withRedis = null) use ($app) {

    Apt::update();
    Nginx::install();
    Php::install();
    PhpFpm::install();
    MySql::install();

    if ($withRedis) {
        Redis::install();
    }

    info('Provisioner installed successfully!');
})->descriptions('Install the Provisioner services');

$app->command('run [--access-token] [token]', function ($token) {
    Serve::run($token);
})->descriptions('Run Provisioner service');

try {
    $app->run();
} catch (Exception $e) {
    warning($e->getMessage());
}
