<?php


namespace App;


class Flash
{
    public static function addMessage($message): void
    {
        if (!isset($_SESSION['flash_notification'])) {
            $_SESSION['flash_notification'] = [];
        }
        $_SESSION['flash_notification'][] = $message;
    }

    public static function getMessage()
    {
        if (isset($_SESSION['flash_notification'])) {
            $message = $_SESSION['flash_notification'];
            unset($_SESSION['flash_notification']);
            return $message;
        }
    }
}