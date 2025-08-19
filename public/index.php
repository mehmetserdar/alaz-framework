
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';

use League\Container\Container;
use App\Router as AppRouter;
use Symfony\Component\Dotenv\Dotenv;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;
use HttpSoft\Emitter\SapiEmitter;
use App\Config;

// Ortam değişkenlerini yükle
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
Config::load(__DIR__ . '/../config/app.php');

// DI Container
$container = new Container();

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);
$psrRequest = $creator->fromGlobals();
$container->add('psr_request', $psrRequest);
$container->add('request', new \App\Request($psrRequest));
$container->add('view', new \App\ViewFactory());

$router = new AppRouter($container);
require __DIR__ . '/../routes/web.php';

try {
    $response = $router->dispatch($psrRequest);
} catch (\Throwable $e) {
    $response = $psr17Factory->createResponse(500)
        ->withHeader('Content-Type', 'text/html');
    $errorHtml = ($_ENV['APP_ENV'] ?? 'production') === 'development'
        ? '<h1>Error</h1><pre>' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>'
        : '<h1>Internal Server Error</h1>';
    $stream = $psr17Factory->createStream($errorHtml);
    $response = $response->withBody($stream);
}

if (ob_get_level()) {
    ob_end_clean();
}

$emitter = new SapiEmitter();
$emitter->emit($response);
