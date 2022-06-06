<?php

/**
 * This class insert new Presences in register file
 */

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
use App\Traits\DataManipulator;
use App\Validate;

class PresenceManager implements CommandContract {
    
    use FileManager, DataManipulator;

    /** @var string $command defines the name that the command receives to be executed in the cli */
    protected $command = 'Presence';

    /** @var string $storage_file defines the path to the folder where the register file will be stored*/
    public $storage_file;

    /** @var string $content defines the content that will be saved in the register file*/
    public $content;

    /** @property class $validate defines new object for Validate Class */
    public $validate;

    /**
    * Construct method defines default values
    *
    * @return void
    *
    * @access public
    */

    public function __construct()
    {
        $this->storage_file = defaultStorageFile();
        $this->file = $this->getContent($this->storage_file);
        $this->validate = new Validate();
    }

    /**
    * Default run default method for command execution call
    *
    * @param array $params array of arguments passed by the cli.
    *
    * @return string A echo message of command progress.
    *
    * @access public
    */
    public function run($params)
    {
        $args = $params['args'];        
        
        if ($this->studentExists($this->file, $args[0])) {          
            
            $validate = $this->validate->execute($this->fields($args), $this->rules());
            
            if ($validate['valid']) {
                $this->insertRow($this->storage_file, $this->createRow($args));                
            }
            else {
                $this->validate->printMessages($validate);
            }
        }             

        $list = $this->classAttendanceTimeList($this->getContent($this->storage_file));

        foreach($list as $line) {
            echo "{$line['name']}: {$line['message']} \n";
        }
    }

    /**
    * Add of new line in register file
    *
    * @param array $data array of treated arguments passed by the cli.
    *
    * @return array with new row with command name and arguments
    *
    * @access public
    */
    public function createRow($data)
    {        
        return [
            $this->command,
            ...$data
        ];
    }

    /**
    * Parse of cli arguments for data references of register file
    *
    * @param array $data array of treated arguments passed by the cli.
    *
    * @return array new array with coluns of row parsed
    *
    * @access public
    */
    public function fields($data)
    {
        return [
            'day' => $data[1],
            'start' => $data[2],
            'end' => $data[3]
        ];
    }

    /**
    * Definitions of arguments rules for register    
    *
    * @return array with rules for each field column of cli arguments
    *
    * @access public
    */
    public function rules()
    {
        return [
            'day' => 'isValidDay',
            'start' => 'isValidHour|isWorkingClass:start|isLessThan:end',
            'end' => 'isValidHour|isWorkingClass:end|isGreaterThan:start|minimumTime:start'
        ];
    }
}