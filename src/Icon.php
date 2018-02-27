<?php

namespace Depsimon\BladeFa5;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Icon implements Htmlable
{
    private $iconName;
    private $iconWeight;
    private $factory;
    private $attrs = [];

    public function __construct($iconName, $iconWeight, $factory, $attrs = [])
    {
        $this->iconName = $iconName;
        $this->iconWeight = $iconWeight;
        $this->factory = $factory;
        $this->attrs = $attrs;
    }

    public function toHtml()
    {
        return new HtmlString($this->renderFromSprite());
    }

    public function __call($method, $args)
    {
        if (count($args) === 0) {
            $this->attrs[] = snake_case($method, '-');
        } else {
            $this->attrs[snake_case($method, '-')] = $args[0];
        }

        return $this;
    }

    public function renderFromSprite()
    {
        return vsprintf('<svg%s><use xmlns:xlink="http://www.w3.org/1999/xlink" href="#%s-%s"></use></svg>', [
            $this->renderAttributes(),
            $this->iconWeight,
            $this->iconName
        ]);
    }

    private function renderAttributes()
    {
        if (count($this->attrs) == 0) {
            return '';
        }

        return ' ' . collect($this->attrs)->map(function ($value, $attr) {
            if (is_int($attr)) {
                return $value;
            }

            return sprintf('%s="%s"', $attr, $value);
        })->implode(' ');
    }
}