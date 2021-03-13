<?php


namespace App\Controllers;

use \Core\View;
use App\Auth;

class Home extends \Core\Controller
{
    public function indexAction(): void
    {
//        View::renderTemplate('Home/index.html', [
//            'user' => Auth::getUser()
//        ]);
        View::renderTemplate('Home/index.html');
    }
}