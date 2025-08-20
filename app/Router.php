<?php

namespace App;

use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;
use League\Container\Container;

class Router
{
    protected $router;
    protected $container;
    protected $middlewares = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->router = new LeagueRouter();
        $this->router->setStrategy(new ApplicationStrategy());
    }

    public function map($method, $path, $handler)
    {
        $this->router->map($method, $path, $handler);
    }

    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function get($path, $handler)
    {
        $this->map('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->map('POST', $path, $handler);
    }

    public function put($path, $handler)
    {
        $this->map('PUT', $path, $handler);
    }

    public function delete($path, $handler)
    {
        $this->map('DELETE', $path, $handler);
    }

    public function group($prefix, $callback)
    {
        return $this->router->group($prefix, $callback);
    }

    public function dispatch($request)
    {
        $handler = function ($req) {
            return $this->router->dispatch($req);
        };
        foreach (array_reverse($this->middlewares) as $middleware) {
            $handler = function ($req) use ($middleware, $handler) {
                $instance = is_string($middleware) ? new $middleware() : $middleware;
                return $instance($req, $handler);
            };
        }
        return $handler($request);
    }

    public function getRouter()
    {
        return $this->router;
    }
}
