<?php

namespace App;

use Nyholm\Psr7\Response as PsrResponse;

class Response
{
    public static function html($content, $status = 200, array $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'text/html; charset=utf-8'], $headers);
        return new PsrResponse($status, $headers, $content);
    }

    public static function json($data, $status = 200, array $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'application/json'], $headers);
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return new PsrResponse($status, $headers, $json);
    }

    public static function text($content, $status = 200, array $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'text/plain; charset=utf-8'], $headers);
        return new PsrResponse($status, $headers, $content);
    }
}
