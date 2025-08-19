<?php

namespace App;

class Crypt
{
    public static function encrypt($data, $key)
    {
        $iv = random_bytes(16);
        $cipher = 'AES-256-CBC';
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public static function decrypt($data, $key)
    {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        $cipher = 'AES-256-CBC';
        return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
    }
}
