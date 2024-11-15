<?php

namespace App\Template;

use App\View;

final class DefaultTemplate implements View
{
    public function __construct(
        private readonly string $title,
        private readonly View $view
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
        </head>
        <body>
            <div class="main-nav">
                <nav>
                    <a class="logo" href="/">Super secure hosting</a>
                    <a href="#">asdf</a>
                </nav>
            </div>
            <?= $this->view->render() ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}