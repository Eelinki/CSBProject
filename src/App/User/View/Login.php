<?php
declare(strict_types=1);

namespace App\User\View;

use App\View\View;

final class Login implements View
{

    public function render(): string
    {
        ob_start();
        ?>
        <div class="page-login">
            <h1>Login</h1>
            <form method="post" action="/api/login" class="login" data-ajax>
                <label>
                    <span>Username</span>
                    <input type="text" name="username">
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password">
                </label>
                <input type="submit" value="Log in">
                <a href="/register" class="underline small">Create an account</a>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}