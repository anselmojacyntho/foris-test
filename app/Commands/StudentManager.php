<?php

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
use App\Traits\DataManipulator;

class StudentManager implements CommandContract {

    use FileManager, DataManipulator;

    protected $command = 'Student';
    
    public $storage_file;
    public $content;

    public function __construct()
    {
        $this->storage_file = defaultStorageFile();
        $this->file = $this->getContent($this->storage_file);
    }

    public function run($params)
    {
        $student_name = $params['args'][0];

        if (!$this->studentExists($this->file, $student_name)) {
            $this->insertRow($this->storage_file, $this->createRow($student_name));    
        }

        $list = $this->classAttendanceTimeList($this->getContent($this->storage_file));

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