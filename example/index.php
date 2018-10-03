<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use Embryo\Container\Container;
use Embryo\Http\Server\MiddlewareDispatcher;
use Embryo\Http\Factory\{ServerRequestFactory, ResponseFactory};
use Middlewares\{Uuid, ResponseTime};

$request = (new ServerRequestFactory)->createServerRequestFromServer();
$response = (new ResponseFactory)->createResponse(200);
$container = new Container;

$middleware = new MiddlewareDispatcher($container);
$middleware->add(Uuid::class);
$middleware->add(ResponseTime::class);
$response = $middleware->dispatch($request, $response);

echo 'X-Response-Time: ' . $response->getHeaderLine('X-Response-Time').'<br/>';
echo 'X-Uuid: ' . $response->getHeaderLine('X-Uuid').'<br/>';

echo '<pre>';
    print_r($response->getHeaders());
echo '</pre>';
