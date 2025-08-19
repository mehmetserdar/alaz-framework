<?php

namespace App;

use League\Flysystem\Filesystem as LeagueFilesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class Filesystem
{
    protected $disk;

    public function __construct($root = null)
    {
        $adapter = new LocalFilesystemAdapter($root ?: __DIR__ . '/../storage');
        $this->disk = new LeagueFilesystem($adapter);
    }

    public function write($path, $contents)
    {
        $this->disk->write($path, $contents);
    }

    public function read($path)
    {
        return $this->disk->read($path);
    }

    public function delete($path)
    {
        $this->disk->delete($path);
    }

    public function exists($path)
    {
        return $this->disk->fileExists($path);
    }
}
