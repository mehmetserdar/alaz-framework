<?php

namespace App;

class FilesystemManager
{
    protected $disks = [];

    public function disk($name = 'local')
    {
        if (!isset($this->disks[$name])) {
            // Sadece local disk örneği
            $this->disks[$name] = new Filesystem();
        }
        return $this->disks[$name];
    }
}
