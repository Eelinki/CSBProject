<?php
declare(strict_types=1);

namespace App;

final readonly class Config
{
    public function basePath(): string
    {
        return '/var/www/html';
    }
}