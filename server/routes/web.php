<?php

/** @var FastRoute\RouteCollector $route */
$route->get('/', function () {
    return 'API';
});

$route->get('/users', function () {
});

$route->get('/users/{id}', function ($id) {
    return $id;
});
$route->get('/{name}', function ($name) {
    return "<h1> Hi, {$name}! </h1>";
});
