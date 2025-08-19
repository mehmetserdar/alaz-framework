<?php

namespace App;

use Psr\Http\Message\ServerRequestInterface;

class Request
{
    protected $psrRequest;

    public function __construct(ServerRequestInterface $psrRequest)
    {
        $this->psrRequest = $psrRequest;
    }

    public function all()
    {
        return array_merge($this->psrRequest->getQueryParams(), $this->psrRequest->getParsedBody() ?: []);
    }

    public function input($key, $default = null)
    {
        $data = $this->all();
        return $data[$key] ?? $default;
    }

    public function query($key, $default = null)
    {
        $data = $this->psrRequest->getQueryParams();
        return $data[$key] ?? $default;
    }

    public function post($key, $default = null)
    {
        $data = $this->psrRequest->getParsedBody() ?: [];
        return $data[$key] ?? $default;
    }

    public function method()
    {
        return $this->psrRequest->getMethod();
    }

    public function psr()
    {
        return $this->psrRequest;
    }
}
