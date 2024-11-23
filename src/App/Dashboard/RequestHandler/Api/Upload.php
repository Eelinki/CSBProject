<?php
declare(strict_types=1);

namespace App\Dashboard\RequestHandler\Api;

use App\Config;
use App\Database\File;
use App\Database\User;
use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\BadRequestException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class Upload implements RequestHandlerInterface
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
            throw new BadRequestException('You need to be logged in to upload files');
        }
        $user = (new User($this->db))->getUserById($_SESSION['user_id']);

        $repo = new File($this->db);

        /** @var UploadedFileInterface $file */
        $file = $request->getUploadedFiles()['file'];
        $tmpFile = $file->getStream()->getMetadata('uri');
        if ($file->getError() !== 0 || !is_file($tmpFile)) {
            throw new BadRequestException("Invalid file uploaded");
        }

        $mime = mime_content_type($tmpFile);
        $fileExt = match ($mime) {
            "image/jpg", "image/jpeg" => "jpg",
            "image/png" => "png",
            "application/zip", "application/x-zip-compressed" => "zip",
            default => throw new BadRequestException("Unsupported file type")
        };

        $clientFilename = basename($file->getClientFilename() ?? 'file');

        $fileId = $repo->addFile($user, $clientFilename, $fileExt);

        $config = new Config();
        $targetPath = $config->basePath() . '/uploads/' . $fileId;

        $file->moveTo($targetPath);

        return new EmptyResponse();
    }
}