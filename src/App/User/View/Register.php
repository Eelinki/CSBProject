<?php
declare(strict_types=1);

namespace App\User\View;

use App\View\View;

final class Register implements View
{

    public function render(): string
    {
        ob_start();
        ?>
        <div class="page-login">
            <h1>Register</h1>
            <form method="post" action="/api/register" class="login" data-ajax>
                <label>
                    <span>Username</span>
                    <input type="text" name="username">
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password">
                </label>
                <label>
                    <span>Password (again)</span>
                    <input type="password" name="password_again">
                </label>
                <input type="submit" value="Register">
                <a href="/login" class="underline small">Login</a>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}