<?php


namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    // render a view file
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        $file = "../App/Views/$view"; // related to core directory
        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new Environment($loader);
//            $twig->addGlobal('session', $_SESSION);
//            $twig->addGlobal('is_logged_in', \App\Auth::isLoggedIn());
            $twig->addGlobal('current_user', \App\Auth::getUser());
            $twig->addGlobal('flash_messages', \App\Flash::getMessage());
        }
        echo $twig->render($template, $args);
    }
}