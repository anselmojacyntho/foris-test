<?php

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
use App\Traits\DataManipulator;

class StudentManager implements CommandContract {

    use FileManager, DataManipulator;

    protected $command = 'Student';
    
    public $storageFile;
    public $content;

    public function __construct()
    {
        $this->storageFile = default_storage_file();
        $this->file = $this->getContent($this->storageFile);
    }

    public function run($params)
    {
        $studentName = $params['args'][0];

        if (!$this->studentExists($this->file, $studentName)) {
            $this->insertRow($this->storageFile, $this->createRow($studentName));    
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
            $data
        ];
    }
}