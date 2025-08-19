<?php

if (!function_exists('app')) {
    /**
     * Get the available container instance
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return \alaz\Application::getInstance();
        }

        return \alaz\Application::getInstance()->get($abstract);
    }
}

if (!function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view
     */
    function view($view = null, $data = [])
    {
        $factory = app('view');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->render($view, $data);
    }
}
if (!function_exists('route')) {
    /**
     * Generate a URL to a named route
     */
    function route($name, $parameters = [])
    {
        $router = app('router');
        return $router->generate($name, $parameters);
    }
}

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        return data_get(app('config'), $key, $default);
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the path to the storage folder
     */
    function storage_path($path = '')
    {
        return app()->storagePath($path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder
     */
    function public_path($path = '')
    {
        return app()->publicPath($path);
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the path to the base of the install
     */
    function base_path($path = '')
    {
        return app()->basePath($path);
    }
}

if (!function_exists('resource_path')) {
    /**
     * Get the path to the resources folder
     */
    function resource_path($path = '')
    {
        return app()->resourcePath($path);
    }
}

if (!function_exists('data_get')) {
    /**
     * Get an item from an array using "dot" notation
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        foreach ($key as $segment) {
            if (is_array($target) && array_key_exists($segment, $target)) {
                $target = $target[$segment];
            } else {
                return $default;
            }
        }

        return $target;
    }
}
