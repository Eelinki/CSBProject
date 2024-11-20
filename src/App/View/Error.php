<?php
declare(strict_types=1);

namespace App\View;

final readonly class Error implements View
{
    public function __construct(
        private int $code,
        private string $phrase
    ) {
    }

    public function render(): string
    {
        ob_start();
        ?>
        <div class="hero">
            <h1><?= $this->code ?></h1>
            <p><?= $this->phrase ?></p>
        </div>
        <?php
        return ob_get_clean();
    }
}