<?php

use Depsimon\BladeFa5\Fa5Factory;

if (! function_exists('fa5_spritesheets')) {
    function fa5_spritesheets(...$weights)
    {
        return app(Fa5Factory::class)->spritesheets($weights);
    }
}

if (! function_exists('fa5_icon')) {
    function fa5_icon($icon, $weight = null, $class = '', $attrs = [])
    {
        return app(Fa5Factory::class)->icon($icon, $weight, $class, $attrs);
    }
}