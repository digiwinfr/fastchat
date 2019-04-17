<?php
namespace Digiwin\Fastchat\Services;

use Digiwin\Fastchat\Models\User;

class SecurityService
{
    public static function startSession(User $user)
    {
        session_start();
        $_SESSION['user'] = $user;
    }

    public static function destroySession()
    {
        session_start();
        unset($_SESSION['user']);
    }

    public static function hasSession()
    {
        session_start();
        return isset($_SESSION['user']);
    }

    public static function getUser()
    {
        session_start();
        return $_SESSION['user'];
    }
}