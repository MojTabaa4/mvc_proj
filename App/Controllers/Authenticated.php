<?php


namespace App\Controllers;


class Authenticated extends \Core\Controller
{
    protected function before(): void
    {
        $this->requireLogin();
    }
}