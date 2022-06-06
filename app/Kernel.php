<?php

namespace App;

use Exception;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;
class Kernel extends CLI {

    // Register new commands here

    public function register()
    {
        return [
            'File' => new \App\Commands\DataFile,
            'Student' => new \App\Commands\StudentManager,
            'Presence' => new \App\Commands\PresenceManager,
            'Reports' => new \App\Commands\ReportsManager
        ];
    }

    protected function setup(Options $options)
    {
        // $options->registerOption('teste', '123123', '2'); 
    }

    protected function main(Options $options)
    {    
        
        $instance = $this->getInstance($options);

        if (!$instance) {
            dd('Command not found');
        }

        return $instance->run($this->getArgs($options));
    }

    protected function getArgs($options)
    {        
        return [
            'args' => array_slice($options->getArgs(),1),
            'options' => $options
        ];
    }

    protected function getCommand($options)
    {
        return $options->getArgs('command')[0];
    }

    protected function getInstance($options)
    {
        $command = $this->getCommand($options);

        return array_key_exists($command, $this->register()) ? $this->register()[$command] : false;
    }    
}