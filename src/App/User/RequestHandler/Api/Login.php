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

final readonly class Login implements RequestHandlerInterface
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

        $hashedPassword = md5($password);

        $repo = new User($this->db);
        $user = $repo->getUserByLogin($username, $hashedPassword);

        $_SESSION['user_id'] = $user->id();

        return (new Response())->withHeader('Location', '/');
    }
}