<?php
declare(strict_types=1);

use App\Dashboard\RequestHandler\Api\Download;
use App\Dashboard\RequestHandler\Api\Upload;
use App\Dashboard\RequestHandler\Dashboard;
use App\Error\PublicError;
use App\FrontPage\RequestHandler\FrontPage;
use App\User\RequestHandler\Api\Login as LoginApi;
use App\User\RequestHandler\Api\Register as RegisterApi;
use App\User\RequestHandler\Login;
use App\User\RequestHandler\Logout;
use App\User\RequestHandler\Register;
use Laminas\Diactoros\ResponseFactory;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Strategy\JsonStrategy;

require '../vendor/autoload.php';

session_start();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

$db = new PDO(
    'pgsql:host=postgres;dbname=cybersecurity',
    'cybersecurity',
    'cybersecurity',
    [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]
);

$router->map('GET', '/', new FrontPage());
$router->map('GET', '/login', new Login());
$router->map('GET', '/register', new Register());
$router->map('GET', '/logout', new Logout());
$router->map('GET', '/dashboard', new Dashboard($db));
$router->group('/api', function ($group) use ($db) {
    $group->map('POST', '/login', new LoginApi($db));
    $group->map('POST', '/register', new RegisterApi($db));
    $group->map('POST', '/upload', new Upload($db));
    $group->map('GET', '/download/{id}', new Download($db));
})->setStrategy(new JsonStrategy(new ResponseFactory()));

try {
    $response = $router->dispatch($request);
} catch (NotFoundException|BadRequestException|MethodNotAllowedException $e) {
    $response = (new PublicError($e->getStatusCode(), $e->getMessage()))->handle($request);
} catch (Exception) {
    $response = (new PublicError(500, 'Server error!'))->handle($request);
}

(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
