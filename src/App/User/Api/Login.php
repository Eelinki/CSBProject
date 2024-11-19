<?php
declare(strict_types=1);

namespace App\User\Api;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Login implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $username = trim($request->getParsedBody()['username'] ?? '');
        $password = $request->getParsedBody()['password'] ?? '';

        ob_start();

        return new HtmlResponse(ob_get_clean());
    }
}