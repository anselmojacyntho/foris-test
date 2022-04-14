<?php

namespace App\Traits;

use JamesGordo\CSV\Parser;
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

    public function insertRow($filePath, $row)
    {
        $file = fopen($filePath, "a");

        fputcsv($file, $row);
        fclose($file);

        return $this;
    }

    public function getContent($filePath)
    {       
        if (file_exists($filePath) && filesize($filePath) != 4096) {            
            $parse = array_map('str_getcsv', file($filePath));

            return collection($parse);  
        }
        
        return false;
    }

    public function getFilePath($filePath)
    {
        return "{$this->basePath}/{$this->storagePath}/{$filePath}";
    }
}