<?php

namespace App\Models\Service;

use App\Auth;
use App\Flash;
use App\Models\Entities\User;
use Core\View;

class LoginService
{
    public static function createActionController(): bool
    {
        $user = User::authenticate($_POST['email'], $_POST['password']);
        if ($user) {
            // store smaller data in session
            Auth::login($user);
            Flash::addMessage('Login Successfully');
            return True;
        }

        Flash::addMessage('Login unsuccessful please try again');
        return False;
    }

    public static function destroyActionController(): void
    {
        Auth::logout();
    }

    public static function showLogoutMessageActionController(): void
    {
        Flash::addMessage('Logout Successfully');
    }

}