<?php
declare(strict_types=1);

namespace App\Database;

use App\Models\User as UserModel;
use League\Route\Http\Exception\BadRequestException;
use PDO;

final readonly class User
{
    public function __construct(private PDO $db)
    {
    }

    public function usernameIsFree(string $username): bool
    {
        $q = $this->db->prepare('SELECT * FROM user_account WHERE username = :username');
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

    /**
     * @throws BadRequestException
     */
    public function getUserByLogin(string $username, string $passwordHash): UserModel
    {
        $q = $this->db->query("SELECT * FROM user_account WHERE username = '" . $username . "' AND password = '" . $passwordHash . "'");

        if ($q->rowCount() === 0) {
            throw new BadRequestException('Wrong username or password!');
        }

        $row = $q->fetchObject();

        return new UserModel(
            (int)$row->id,
            (string)$row->username,
            (string)$row->password,
            (boolean)$row->is_admin
        );
    }
}