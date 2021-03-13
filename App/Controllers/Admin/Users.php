<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{
    protected function before()
    {
        echo 'before action ';
        echo "<br>";
        // check that user logged in as an admin
        // return false;
    }

    public function indexAction()
    {
        echo "it's user index action";
        echo "<br>";
    }

    protected function after()
    {
        echo ' after action ';

    }
}