<?php

namespace App\Commands;

use App\Contracts\CommandContract;
use App\Traits\FileManager;
class DataFile implements CommandContract {

    use FileManager;

    public function run($args)
    {
        $file = $args['args'][0];

        $create_file = $this->createFile($file);

        dump('Arquivo criado');
    }
}