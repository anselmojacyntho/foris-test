<?php

namespace App\Contracts;

interface CommandContract {
    public function run( Array $args );
}