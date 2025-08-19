<?php
// filepath: routes/web.php

use App\Controllers\HomeController;

$router->map('GET', '/', [HomeController::class, 'index']);
$router->map('POST', '/', [HomeController::class, 'index']);
