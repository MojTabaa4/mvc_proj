<?php


namespace App\Controllers;

use Core\View;
use App\Auth;

class Item extends Authenticated
{
    public function indexAction(): void
    {
//        $this->requireLogin();
        View::renderTemplate('Item/item.html');
    }
}