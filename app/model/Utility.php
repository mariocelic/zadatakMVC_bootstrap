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

    public static function sumProperties(array $arr, $property)
    {
        $sum = 0;
        foreach ($arr as $object) {
            $sum += isset($object->{$property}) ? $object->${property} : 0;
        }

        return $sum;
    }
}
