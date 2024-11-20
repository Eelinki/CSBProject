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
        if ($file->getError() !== 0) {
            throw new BadRequestException("Error {$file->getError()}");
        }

        $clientFilename = basename($file->getClientFilename() ?? 'file');

        $fileId = $repo->addFile($user, $clientFilename);

        $parts = explode('.', $clientFilename);
        if (count($parts) < 2) {
            throw new BadRequestException("File missing extension");
        }
        $fileType = array_pop($parts);

        $config = new Config();

        $targetPath = $config->basePath() . '/uploads/' . $fileId . '.' . $fileType;

        if (!is_dir($config->basePath() . '/uploads')) {
            mkdir($config->basePath() . '/uploads');
        }

        $file->moveTo($targetPath);

        return new EmptyResponse();
    }
}