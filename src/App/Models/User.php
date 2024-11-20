<?php
declare(strict_types=1);

namespace App\Models;

final readonly class User
{
    public function __construct(
        private int $id,
        private string $username,
        private string $passwordHash,
        private bool $isAdmin
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function passwordHash(): string
    {
        return $this->passwordHash;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }
}