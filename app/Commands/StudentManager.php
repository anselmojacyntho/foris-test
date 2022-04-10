<?php

namespace App\Commands;

use App\Contracts\CommandContract;

class StudentManager implements CommandContract {

    public function run($args)
    {
        echo "Ola";
    }
}