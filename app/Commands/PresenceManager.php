<?php

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
use App\Traits\DataManipulator;
use PhpParser\Node\Stmt\Foreach_;

class PresenceManager implements CommandContract {
    
    use FileManager, DataManipulator;

    protected $command = 'Presence';

    public $storageFile;
    public $content;

    public function __construct()
    {
        $this->storageFile = default_storage_file();
        $this->file = $this->getContent($this->storageFile);
    }

    public function run($params)
    {
        $args = $params['args'];        
        
        if ($this->studentExists($this->file, $args[0])) {            
            $this->insertRow($this->storageFile, $this->createRow($args)); 
        }      
        
        $list = $this->classAttendanceTimeList($this->getContent($this->storageFile));

        foreach($list as $line) {
            echo "{$line['name']}: {$line['time']} \n";
        }
    }

    public function createRow($data)
    {        
        return [
            $this->command,
            ...$data
        ];
    }
}