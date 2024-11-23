<?php
declare(strict_types=1);

namespace App\User\RequestHandler\Api;

use App\Database\User;
use Laminas\Diactoros\Response;
use League\Route\Http\Exception\BadRequestException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Register implements RequestHandlerInterface
{
    public function __construct(private PDO $db)
    {
    }

    /**
     * @throws BadRequestException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $username = trim($request->getParsedBody()['username'] ?? '');
        $password = $request->getParsedBody()['password'] ?? '';
        $passwordAgain = $request->getParsedBody()['password_again'] ?? '';

        $repo = new User($this->db);
        if (!$repo->usernameIsFree($username)) {
            throw new BadRequestException('Username is already registered');
        }

        if ($password !== $passwordAgain) {
            throw new BadRequestException('Passwords do not match');
        }

        $hashedPassword = md5($password);

        $userId = $repo->createUser($username, $hashedPassword);
        $_SESSION['user_id'] = $userId;

        return (new Response())->withHeader('Location', '/');
    }
}