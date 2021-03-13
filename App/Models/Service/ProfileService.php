<?php


namespace App\Models\Service;


use App\Auth;
use App\Models\Entities\User;
use Core\View;

class ProfileService
{
    public static function editActionController(): ?User
    {
        $user = Auth::getUser();
        $user->saveEdit();

        return $user;
    }

}