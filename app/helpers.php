<?php

if (! function_exists('getConfig')) {
    function getConfig($path) {
        
        $params = explode('.', $path);
        $config = include dirname(__DIR__, 1) . "/config/{$params[0]}.php";
        
        return count($params) > 1 ? $config[$params[1]] : $config;
    }
}

if (! function_exists('basePath')) {
    function basePath() {            
        return dirname(__DIR__, 1);
    }
}

if (! function_exists('defaultStorageFile')) {
    function defaultStorageFile() {       

        $storage = getConfig('storage.path');
        $path = basePath() . "/{$storage}";
        
        $dir = opendir($path);

        return $path . readdir($dir);
    }
}

if (! function_exists('collection')) {
    function collection(Array $array) {
        return new Illuminate\Support\Collection($array);
    }
}