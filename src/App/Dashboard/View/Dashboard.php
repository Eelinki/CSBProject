<?php
declare(strict_types=1);

namespace App\Dashboard\View;

use App\Models\User;
use App\View\View;

final readonly class Dashboard implements View
{
    public function __construct(private User $user)
    {
    }

    public function render(): string
    {
        ob_start();
        ?>
        <h1>Dashboard</h1>
        <div class="profile">
            <h3>Hello, <?= $this->user->username() ?></h3>
            <p><?= $this->user->isAdmin() ? 'Admin' : 'Regular user' ?></p>
        </div>
        <h2>Your files</h2>
        <div class="file-list">

        </div>
        <?php
        return ob_get_clean();
    }
}