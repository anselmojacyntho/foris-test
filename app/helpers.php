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