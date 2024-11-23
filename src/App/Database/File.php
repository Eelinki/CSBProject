<?php
declare(strict_types=1);

namespace App\Database;

use App\Models\File as FileModel;
use App\Models\User as UserModel;
use League\Route\Http\Exception\BadRequestException;
use PDO;

final readonly class File
{
    public function __construct(private PDO $db)
    {
    }

    public function addFile(UserModel $user, string $filename, string $ext): int
    {
        $q = $this->db->prepare('INSERT INTO file (user_id, filename, extension) VALUES (:user_id, :filename, :extension)');
        $q->bindValue(':user_id', $user->id(), PDO::PARAM_INT);
        $q->bindValue(':filename', $filename);
        $q->bindValue(':extension', $ext);
        $q->execute();

        return (int)$this->db->lastInsertId();
    }

    /**
     * @param UserModel $user
     * @return FileModel[]
     */
    public function filesByUser(UserModel $user): array
    {
        $q = $this->db->prepare('SELECT * FROM file WHERE user_id = :user_id');
        $q->bindValue(':user_id', $user->id(), PDO::PARAM_INT);
        $q->execute();
        
        $files = [];
        while ($row = $q->fetchObject()) {
            $files[] = new FileModel(
                (int)$row->id,
                (int)$row->user_id,
                (string)$row->filename,
                (string)$row->extension
            );
        }

        return $files;
    }

    /**
     * @throws BadRequestException
     */
    public function fileById(int $id): FileModel
    {
        $q = $this->db->prepare('SELECT * FROM file WHERE id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();

        if ($q->rowCount() === 0) {
            throw new BadRequestException('File not found');
        }

        $row = $q->fetchObject();

        return new FileModel(
            (int)$row->id,
            (int)$row->user_id,
            (string)$row->filename,
            (string)$row->extension
        );
    }
}