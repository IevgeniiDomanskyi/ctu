<?php

if ( ! function_exists('service')) {
    function service($service = null) {
        $class = '\\App\\Http\\Services\\'.$service.'Service';
        return resolve($class);
    }
}