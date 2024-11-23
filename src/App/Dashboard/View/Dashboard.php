<?php
declare(strict_types=1);

namespace App\Dashboard\View;

use App\Models\File;
use App\Models\User;
use App\View\View;

final readonly class Dashboard implements View
{
    /**
     * @param User $user
     * @param File[] $files
     */
    public function __construct(private User $user, private array $files)
    {
    }

    public function render(): string
    {
        ob_start();
        ?>
        <div class="page">
            <h1>Dashboard</h1>
            <div class="profile">
                <h3>Hello, <?= $this->user->username() ?></h3>
                <p><?= $this->user->isAdmin() ? 'Admin' : 'Regular user' ?></p>
            </div>
            <h2>Upload a file</h2>
            <form method="post" action="/api/upload" class="file-upload" data-ajax data-reload>
                <label>
                    <span>File</span>
                    <input type="file" name="file" accept=".jpg, .jpeg, .png" />
                </label>
                <input type="submit" value="Upload">
            </form>
            <h2>Your files</h2>
            <div class="file-list">
                <?php foreach ($this->files as $file): ?>
                    <div class="file">
                        <?= $file->filename() ?>
                        <div class="actions">
                            <a class="button" href="/api/download/<?= $file->id() ?>">Download</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}