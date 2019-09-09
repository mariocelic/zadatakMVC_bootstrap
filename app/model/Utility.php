<?php

class Utility
{
    public static function active($path)
    {
        if (Request::pathInfo() === $path) {
            return ' class="active"';
        } else {
            return '';
        }
    }
}
