<?php

namespace alaz;

use League\Container\Container;
use League\Container\ReflectionContainer;

class Application extends Container
{
    protected $basePath;
    protected $bootstrappers = [];
    protected $booted = false;
    protected $serviceProviders = [];
    protected $loadedProviders = [];

    public function __construct($basePath = null)
    {
        parent::__construct();

        // Auto-wiring için reflection container ekle
        $this->delegate(new ReflectionContainer());

        $this->basePath = $basePath ?: $this->guessBasePath();
        $this->registerBaseBindings();
    }

    /**
     * Guess the base path of the application
     */
    protected function guessBasePath()
    {
        $reflection = new \ReflectionClass($this);
        $dir = dirname($reflection->getFileName());

        // app/ klasöründen çık, kök dizine git
        return dirname($dir);
    }

    /**
     * Register base bindings in the container
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->add('app', $this);
        $this->add(Application::class, $this);
        $this->add(\alaz\Application::class, $this);

        // Path bindings
        $this->add('path', $this->basePath());
        $this->add('path.base', $this->basePath());
        $this->add('path.config', $this->configPath());
        $this->add('path.storage', $this->storagePath());
        $this->add('path.resources', $this->resourcePath());
    }

    /**
     * Bootstrap the application with the given bootstrappers
     */
    public function bootstrapWith(array $bootstrappers)
    {
        $this->bootstrappers = $bootstrappers;

        foreach ($bootstrappers as $bootstrapper) {
            $this->get($bootstrapper)->bootstrap($this);
        }

        $this->booted = true;
    }

    /**
     * Get the base path of the application
     */
    public function basePath($path = '')
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    /**
     * Get the path to the application configuration files
     */
    public function configPath($path = '')
    {
        return $this->basePath('config') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    /**
     * Get the path to the storage directory
     */
    public function storagePath($path = '')
    {
        return $this->basePath('storage') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    /**
     * Get the path to the resources directory
     */
    public function resourcePath($path = '')
    {
        return $this->basePath('resources') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    /**
     * Get the path to the public directory
     */
    public function publicPath($path = '')
    {
        return $this->basePath('public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    /**
     * Get the path to the database directory
     */
    public function databasePath($path = '')
    {
        return $this->basePath('database') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    /**
     * Register a service provider
     */
    public function register($provider, $force = false)
    {
        if (($registered = $this->getProvider($provider)) && !$force) {
            return $registered;
        }

        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        $this->markAsRegistered($provider);

        if ($this->booted && method_exists($provider, 'boot')) {
            $provider->boot();
        }

        return $provider;
    }

    /**
     * Get the registered service provider instance if it exists
     */
    public function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    /**
     * Get the registered service provider instances if any exist
     */
    public function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return array_filter($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    /**
     * Resolve a service provider instance from the class name
     */
    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    /**
     * Mark the given provider as registered
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;
        $this->loadedProviders[get_class($provider)] = true;
    }

    /**
     * Boot the application's service providers
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->serviceProviders as $provider) {
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }
        }

        $this->booted = true;
    }

    /**
     * Determine if the application is in the local environment
     */
    public function isLocal()
    {
        return $this->environment(['local', 'development']);
    }

    /**
     * Determine if the application is in the production environment
     */
    public function isProduction()
    {
        return $this->environment('production');
    }

    /**
     * Get or check the current application environment
     */
    public function environment(...$environments)
    {
        if (count($environments) > 0) {
            return in_array($this->getEnvironment(), $environments);
        }

        return $this->getEnvironment();
    }

    /**
     * Get the current application environment
     */
    protected function getEnvironment()
    {
        return $_ENV['APP_ENV'] ?? 'production';
    }

    /**
     * Determine if the application is running in the console
     */
    public function runningInConsole()
    {
        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }

    /**
     * Get the version number of the application
     */
    public function version()
    {
        return 'alaz Framework 1.0.0';
    }

    /**
     * Set the globally available instance of the container
     */
    public static function setInstance($container = null)
    {
        static::$instance = $container;
    }

    /**
     * Get the globally available instance of the container
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * Set the application instance
     */
    protected static $instance;
}
