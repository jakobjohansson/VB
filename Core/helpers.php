<?php

/**
 * kiwi helpers file.
 */
if (!function_exists('dd')) {
    function dd($param)
    {
        echo '<pre><code>';
        var_dump($param);
        echo '</code></pre>';
        die();
    }
}

if (!function_exists('resolve')) {
    function resolve($key)
    {
        return \kiwi\Container::resolve($key);
    }
}

if (!function_exists('bind')) {
    function bind($key, $value)
    {
        \kiwi\Container::bind($key, $value);
    }
}

if (!function_exists('route')) {
    function route()
    {
        return kiwi\Http\Request::uri();
    }
}

if (!function_exists('isRoute')) {
    function isRoute($route)
    {
        return kiwi\Http\Request::uri() === $route;
    }
}
