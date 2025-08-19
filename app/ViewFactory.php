<?php

namespace App;

use League\Plates\Engine;

class ViewFactory
{
    protected $plates;

    public function __construct()
    {
        $views = __DIR__ . '/../resources/views';
        $this->plates = new Engine($views);
    }

    /**
     * Render a Plates template with given data
     * @param string $view
     * @param array $data
     * @return string
     */
    public function render($view, array $data = [])
    {
        // .php uzantısı olmadan çağırılır: $view = 'home' => home.php
        return $this->plates->render($view, $data);
    }
}
