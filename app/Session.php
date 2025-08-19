<?php

namespace App;

class Session
{

    public function isStarted()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }



    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function all()
    {
        return $_SESSION;
    }

    public static function destroy()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
