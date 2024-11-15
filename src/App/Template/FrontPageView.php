<?php

namespace App\Template;

use App\View;

final class FrontPageView implements View
{

    public function render(): string
    {
        ob_start();
        ?>
        <div class="hero">
            <h1>Super secure hosting</h1>
            <h2>Your files are safe with us!</h2>
            <div class="buttons">
                <a class="button alt" href="#">Get started</a>
                <a class="button" href="#">Log in</a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}