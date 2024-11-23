<?php
declare(strict_types=1);

namespace App\Dashboard\RequestHandler\Api;

use App\Config;
use App\Database\File;
use App\Database\User;
use Laminas\Diactoros\Response;
use League\Route\Http\Exception\BadRequestException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Download implements RequestHandlerInterface
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
            throw new BadRequestException('You need to be logged in to download files');
        }
        $user = (new User($this->db))->getUserById($_SESSION['user_id']);

        $repo = new File($this->db);

        $fileId = (int)$request->getAttribute('id', '0');
        $file = $repo->fileById($fileId);

        if ($file->userId() !== $user->id()) {
            throw new BadRequestException('You are not allowed to download this file');
        }

        $config = new Config();
        $filePath = $config->basePath() . '/uploads/' . $file->id();

        if (!is_file($filePath)) {
            throw new BadRequestException('File not found');
        }

        $fileType = mime_content_type($filePath);
        $fileSize = filesize($filePath);

        $stream = fopen($filePath, 'r');

        return (new Response(
            $stream,
            200,
            [
                'Content-Disposition' => ['attachment; filename="' . $file->filename() . '"'],
                'Content-Type' => [$fileType],
                'Content-Length' => [$fileSize],
            ]
        ));
    }
}