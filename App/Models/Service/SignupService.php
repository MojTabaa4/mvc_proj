<?php


namespace App\Models\Service;


use App\Models\Entities\User;
use Core\View;

class SignupService
{
    public static function createActionController(): ?User
    {
//        dump($_POST);
        $user = new User($_POST);
        $user->save();

        return $user;
    }

    public static function editActionController(): ?User
    {
        $user = new User($_POST);
        $user->save();

        return $user;
    }
}