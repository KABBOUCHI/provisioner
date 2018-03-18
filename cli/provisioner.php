#!/usr/bin/env php
<?php
/**
 * Load correct autoloader depending on install location.
 */
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    require __DIR__.'/../../../autoload.php';
}

use Silly\Application;
use Illuminate\Container\Container;

Container::setInstance(new Container);

$version = '0.0.1';

$app = new Application('Provisioner', $version);

$app->command('install [--with-redis]', function ($withRedis = null) use ($app) {
    CommandLine::quietly('mkdir -p ~/.provisioner && touch ~/.provisioner/error.log');
    Apt::update();
    CommandLine::quietly('apt-get install -y --force-yes software-properties-common  curl git zip unzip');
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
