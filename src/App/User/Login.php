<?php
declare(strict_types=1);

namespace App\User;

use App\Template\DefaultTemplate;
use App\Template\Login as LoginView;
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