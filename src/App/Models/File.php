<?php
declare(strict_types=1);

namespace App\Models;

final readonly class File
{
    public function __construct(
        private int $id,
        private int $userId,
        private string $filename,
        private string $extension
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function filename(): string
    {
        return $this->filename;
    }

    public function extension(): string
    {
        return $this->extension;
    }
}