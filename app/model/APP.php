<?php

class App
{
    public static function start()
    {
        $pathInfo = Request::pathinfo();

        $pathParts = explode('/', $pathInfo);

        if (!isset($pathParts[1]) || empty($pathParts[1])) {
            $controller = 'Index';
        } else {
            $controller = ucfirst(strtolower($pathParts[1]));
        }

        $controller .= 'Controller';

        if (!isset($pathParts[2]) || empty($pathParts[2])) {
            $function = 'index';
        } else {
            $function = strtolower($pathParts[2]);
        }

        if (class_exists($controller) && method_exists($controller, $function)) {
            $instanca = new $controller();
            $instanca->$function();
        } else {
            header('HTTP/1.0 404 Not Found');
        }
    }

    public static function config($key)
    {
        $config = include BP.'app/config.php';

        return $config[$key];
    }
}
