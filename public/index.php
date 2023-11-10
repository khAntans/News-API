<?php

declare(strict_types=1);


use App\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/[...]', ['App\Controllers\NewsController', 'index']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        dump('404');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        dump('405');
        break;
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = $routeInfo[1];
        $vars = $_GET;

        $response = (new $controller)->{$method}();


        $loader = new FilesystemLoader('../app/views/');

        $twig = new Environment($loader);

        /**
         * @var Response $response
         */
        try {
            echo $twig->render($response->getViewName() . '.twig', $response->getData());
        } catch (\Twig\Error\LoaderError $e) {
            echo 'Loader Error';
        } catch (\Twig\Error\RuntimeError $e) {
            echo 'Runtime error';
        } catch (\Twig\Error\SyntaxError $e) {
            echo 'Syntax error';
        }
        break;
}
