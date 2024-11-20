<?php
declare(strict_types=1);

namespace App\Database;

use PDO;

final readonly class User
{
    public function __construct(private PDO $db)
    {
    }

    public function usernameIsFree(string $username): bool
    {
        $q = $this->db->prepare('SELECT id FROM user_account WHERE username = :username');
        $q->bindValue(':username', $username);
        $q->execute();

        return $q->rowCount() === 0;
    }

    public function createUser(string $username, string $passwordHash): int
    {
        $q = $this->db->prepare('INSERT INTO user_account (username, password) VALUES (:username, :password)');
        $q->bindValue(':username', $username);
        $q->bindValue(':password', $passwordHash);
        $q->execute();

        return (int)$this->db->lastInsertId();
    }
}