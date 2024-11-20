<?php
declare(strict_types=1);

namespace App\Dashboard\RequestHandler;

use App\Dashboard\View\Dashboard as DashboardView;
use App\Database\File;
use App\Database\User;
use App\View\DefaultTemplate;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\BadRequestException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Dashboard implements RequestHandlerInterface
{
    public function __construct(private PDO $db)
    {
    }

    /**
     * @throws BadRequestException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!isset($_SESSION['user_id'])) {
            return (new Response())->withHeader('Location', '/login');
        }

        $user = (new User($this->db))->getUserById($_SESSION['user_id']);
        $files = (new File($this->db))->filesByUser($user);

        return new HtmlResponse(
            (new DefaultTemplate(
                'Dashboard',
                new DashboardView($user, $files))
            )->render()
        );
    }
}