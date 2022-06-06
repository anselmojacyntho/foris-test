<?php

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
use App\Traits\DataManipulator;
use App\Traits\ReportManager;

class ReportsManager implements CommandContract {

    use FileManager, DataManipulator, ReportManager;

    protected $command = 'Reports';
    protected $storage; 

    public function __construct()
    {
        $this->storage = $this->getContent(defaultStorageFile());
    }

    public function run($params)
    {
        
        $this->studentByClass($this->storage);
    }
}