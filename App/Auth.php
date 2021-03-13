<?php


namespace App;

use \App\Models\Entities\User;
class Auth
{
    public static function login($user): void
    {
        $_SESSION['user_id'] = $user->getId();
    }

    public static function logout(): void
    {
// Unset all of the session variables
        $_SESSION = [];

        // Delete the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Finally destroy the session
        session_destroy();
    }

    // called when user not logged in
    public static function rememberRequestedPage(): void
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    public static function getReturnToPage(): string
    {
        return $_SESSION['return_to'] ?? '/';
    }

    // also use for user is logged in or not
    public static function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            return User::findById($_SESSION['user_id']);
        }
    }
}