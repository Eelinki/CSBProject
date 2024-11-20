<?php
declare(strict_types=1);

use App\Error\PublicError;
use App\FrontPage\RequestHandler\FrontPage;
use App\User\RequestHandler\Api\Login as LoginApi;
use App\User\RequestHandler\Api\Register as RegisterApi;
use App\User\RequestHandler\Login;
use App\User\RequestHandler\Register;
use Laminas\Diactoros\ResponseFactory;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Strategy\JsonStrategy;

require '../vendor/autoload.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

$router->map('GET', '/', new FrontPage());
$router->map('GET', '/login', new Login());
$router->map('GET', '/register', new Register());
$router->group('/api', function ($group) {
    $group->map('POST', '/login', new LoginApi());
    $group->map('POST', '/register', new RegisterApi());
})->setStrategy(new JsonStrategy(new ResponseFactory()));

try {
    $response = $router->dispatch($request);
} catch (NotFoundException|BadRequestException|MethodNotAllowedException $e) {
    $response = (new PublicError($e->getStatusCode(), $e->getMessage()))->handle($request);
}

(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
