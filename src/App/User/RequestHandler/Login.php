<?php
declare(strict_types=1);

namespace App\User\RequestHandler;

use App\User\View\Login as LoginView;
use App\View\DefaultTemplate;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Login implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            (new DefaultTemplate(
                'Login',
                new LoginView())
            )->render()
        );

    }
}