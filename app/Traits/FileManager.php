<?php

namespace App\Traits;

use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

trait FileManager {

    public $storagePath;
    public $basePath;
    public $file;

    public function __construct()
    {
        $this->storagePath = get_config('storage.path');
        $this->basePath = base_path();       
    }

    public function createFile($filePath)
    {
        $filePath = $this->getFilePath($filePath);

        return fopen($filePath, "w");
    }

    public function writeFile($filePath)
    {
        $this->file = Writer::createFromPath($filePath, 'w+');

        return $this;
    }

    public function insertRow($row)
    {
        $this->file->insertOne($row);
        $this->file->setEscape('');

        return $this;
    }

    public function getContent()
    {
        return $this->file->getContent();
    }

    public function getFilePath($filePath)
    {
        return "{$this->basePath}/{$this->storagePath}/{$filePath}";
    }
}