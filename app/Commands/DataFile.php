<?php

namespace App\Commands;

use App\Contracts\CommandContract;

class DataFile implements CommandContract {

    public function run($args)
    {
        dd($args['args']);
    }
}