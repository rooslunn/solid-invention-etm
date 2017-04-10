<?php
// DIC configuration

use Libs\Cities;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c)
{
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c)
{
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['cities'] = function($c)
{
    return new Cities;
};

$app->add(function ($request, $response, $next) {
    $request = $request->withAttribute('session', $_SESSION);
    return $next($request, $response);
});

$app->add(function ($request, $response, $next) {
    $request = $request->withAttribute('post', $_POST);
    return $next($request, $response);
});