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
use Provisioner\Apt;
use Provisioner\CommandLine;
use Provisioner\MySql;
use Provisioner\Nginx;
use Provisioner\Php;
use Provisioner\Redis;
use Silly\Application;

Container::setInstance(new Container);

$version = '0.0.1';

$app = new Application('Provisioner', $version);

$app->command('install [--with-redis]', function ($withRedis = null) use ($app) {
    $apt = new Apt(new CommandLine);
    $apt->update();

    (new Nginx($apt, $apt->cli))->install();
    (new Php($apt))->install();
    (new MySql($apt))->install();

    if ($withRedis) {
        (new Redis($apt))->install();
    }

    info('Provisioner installed successfully!');
})->descriptions('Install the Provisioner services');

$app->command('run', function () {
    info('Provisioner running...');
})->descriptions('Run Provisioner service');

try {
    $app->run();
} catch (Exception $e) {
    warning($e->getMessage());
}
