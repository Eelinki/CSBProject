<?php
declare(strict_types=1);

namespace App\View;

final readonly class DefaultTemplate implements View
{
    public function __construct(
        private string $title,
        private View $view
    ) {
    }

    public function render(): string
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
            <title><?= $this->title ?></title>

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="/static/css/styles.css">

            <script src="/static/js/bootstrap.js" type="module"></script>
        </head>
        <body>
            <div class="main-nav">
                <nav>
                    <a class="logo" href="/">Super secure hosting</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/logout">Logout</a>
                    <?php else: ?>
                        <a href="/login">Login</a>
                    <?php endif; ?>
                </nav>
            </div>
            <?= $this->view->render() ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}