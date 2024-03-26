<?php
session_start();

include_once('core/autoload.php');
include_once('init.php');

$system = new System();

/* @var string $left
 * @var string $title
 * @var string $content
 */

$left = '';
    
$title = $content = 'Error 404';

$uri = $_SERVER['REQUEST_URI'];
$badUrl = BASE_URL . 'index.php';

if(str_starts_with($uri, $badUrl)){
    $cname = 'Errors\E404';
} else {
    $routes = include('routes.php');
    $url = $_GET['mvcsystemurl'] ?? '';

    $routerRes = $system->parseUrl($url, $routes);
    $cname = $routerRes['controller'];

    $urlLen = strlen($url);

    if($urlLen > 0 && $url[$urlLen - 1] == '/'){
        $url = substr($url, 0, $urlLen - 1);
    }
}

/** @var string $path */
$className = "Controller\\$cname";
$controller = new $className();
$controller->run();