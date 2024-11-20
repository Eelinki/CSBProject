<?php
declare(strict_types=1);

namespace App\User\RequestHandler;

use App\User\View\Login as LoginView;
use App\View\DefaultTemplate;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Logout implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        session_destroy();

        return (new Response())->withHeader('Location', '/');
    }
}