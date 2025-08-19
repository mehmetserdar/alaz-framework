<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index(ServerRequestInterface $request)
    {
        $html = $this->view()->render('welcome', [
            'title' => 'HomeController Controller',
            'message' => 'Bu controller başarıyla oluşturuldu!'
        ]);
        return \App\Response::html($html);
    }
}
