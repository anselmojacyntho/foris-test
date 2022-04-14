<?php

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
use App\Traits\DataManipulator;
use App\Validate;

class PresenceManager implements CommandContract {
    
    use FileManager, DataManipulator;

    protected $command = 'Presence';

    public $storageFile;
    public $content;
    public $validate;

    public function __construct()
    {
        $this->storageFile = default_storage_file();
        $this->file = $this->getContent($this->storageFile);
        $this->validate = new Validate();
    }

    public function run($params)
    {
        $args = $params['args'];        
        
        if ($this->studentExists($this->file, $args[0])) {          
            
            $validate = $this->validate->execute($this->fields($args), $this->rules());
            
            if ($validate['valid']) {
                $this->insertRow($this->storageFile, $this->createRow($args));                
            }
            else {
                $this->validate->printMessages($validate);
            }
        }             

        $list = $this->classAttendanceTimeList($this->getContent($this->storageFile));

        foreach($list as $line) {
            echo "{$line['name']}: {$line['message']} \n";
        }
    }

    public function createRow($data)
    {        
        return [
            $this->command,
            ...$data
        ];
    }

    public function fields($data)
    {
        return [
            'day' => $data[1],
            'start' => $data[2],
            'end' => $data[3]
        ];
    }

    public function rules()
    {
        return [
            'day' => 'isValidDay',
            'start' => 'isValidHour|isWorkingClass:start|isLessThan:end',
            'end' => 'isValidHour|isWorkingClass:end|isGreaterThan:start|minimumTime:start'
        ];
    }
}