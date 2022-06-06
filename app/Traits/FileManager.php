<?php

namespace App\Traits;

use JamesGordo\CSV\Parser;
trait FileManager {

    public $storage_path;
    public $base_path;
    public $file;

    public function __construct()
    {
        $this->storage_path = getConfig('storage.path');
        $this->base_path = basePath();       
    }

    public function createFile($file_path)
    {
        $file_path = $this->getFilePath($file_path);
        
        return fopen($file_path, "w");
    }

    public function insertRow($file_path, $row)
    {
        $file = fopen($file_path, "a");

        fputcsv($file, $row);
        fclose($file);

        return $this;
    }

    public function getContent($file_path)
    {       
        if (file_exists($file_path) 
            && filesize($file_path) != 4096
        ) {            
            $parse = array_map('str_getcsv', file($file_path));

            return collection($parse);  
        }
        
        return false;
    }

    public function getFile_path($file_path)
    {
        return "{$this->base_path}/{$this->storage_path}/{$file_path}";
    }
}