<?php
declare(strict_types=1);

namespace App\User\RequestHandler\Api;

use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Register implements RequestHandlerInterface
{

    /**
     * @throws BadRequestException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $username = trim($request->getParsedBody()['username'] ?? '');
        $password = $request->getParsedBody()['password'] ?? '';
        $passwordAgain = $request->getParsedBody()['password_again'] ?? '';

        if ($password !== $passwordAgain) {
            throw new BadRequestException('Passwords do not match');
        }

        ob_start();

        return new HtmlResponse(ob_get_clean());
    }
}