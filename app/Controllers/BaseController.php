<?php

namespace App\Controllers;

abstract class BaseController
{
    /**
     * View nesnesine erişim
     */
    protected function view()
    {
        global $container;
        return $container->get('view');
    }

    /**
     * Request nesnesine erişim
     */
    protected function request()
    {
        global $container;
        return $container->get('request');
    }

    /**
     * Session işlemleri için yardımcı
     */
    protected function session($key = null, $value = null)
    {
        if ($key === null) {
            return $_SESSION ?? [];
        }
        if ($value === null) {
            return $_SESSION[$key] ?? null;
        }
        $_SESSION[$key] = $value;
        return true;
    }

    /**
     * Kolayca redirect
     */
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}
