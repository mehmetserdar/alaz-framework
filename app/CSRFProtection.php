<?php

namespace App;

class CSRFProtection
{
    public static function generateToken()
    {
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    public static function getToken()
    {
        return $_SESSION['_csrf_token'] ?? self::generateToken();
    }

    public static function checkToken($token)
    {
        return hash_equals(self::getToken(), $token);
    }
}
