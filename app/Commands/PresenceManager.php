<?php

namespace App\Commands;

use App\Contracts\CommandContract;

class PresenceManager implements CommandContract {

    public function run($args)
    {
        echo "Ola";
    }
}