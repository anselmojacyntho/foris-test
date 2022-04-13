<?php

if (! function_exists('get_config')) {
    function get_config($path) {
        
        $params = explode('.', $path);
        $config = include dirname(__DIR__, 1) . "/config/{$params[0]}.php";
        
        return count($params) > 1 ? $config[$params[1]] : $config;
    }
}

if (! function_exists('base_path')) {
    function base_path() {            
        return dirname(__DIR__, 1);
    }
}

if (! function_exists('default_storage_file')) {
    function default_storage_file() {       

        $storage = get_config('storage.path');
        $path = base_path() . "/{$storage}";
        
        $dir = opendir($path);

        return $path . readdir($dir);
    }
}

if (! function_exists('collection')) {
    function collection(Array $array) {
        return new Illuminate\Support\Collection($array);
    }
}