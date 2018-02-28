<?php

namespace Depsimon\BladeFa5;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Fa5Factory
{

    private $config = [
        'weight' => 'far',
        'spritesheets_url' => 'svg/'
    ];

    const WEIGHT_SPRITESHEETS = [
        'far' => 'fa-regular.svg',
        'fal' => 'fa-light.svg',
        'fas' => 'fa-solid.svg',
        'fab' => 'fa-brands.svg'
    ];

    public function __construct($config = [])
    {
        $this->config = Collection::make(array_merge($this->config, $config));
    }

    public function registerBladeTag()
    {
        Blade::directive('fa5', function ($expression) {
            return "<?php echo e(fa5_icon($expression)); ?>";
        });
    }

    public function spritesheetUrl($weight)
    {
        return url($this->config->get('spritesheets_url', function () {
            throw new Exception('No spritesheets_url set!');
        }), '/') . $this->spritesheetName($weight);
    }

    private function spritesheetName($weight)
    {
        return self::WEIGHT_SPRITESHEETS[$weight];
    }

    public function icon($name, $weight = null, $class = '', $attrs = [])
    {
        if (is_array($class)) {
            $attrs = $class;
            $class = '';
        }

        if (is_null($weight)) {
            $weight = $this->config->get('weight', 'far');
        }

        $attrs = array_merge([
            'class' => $this->buildClass($class),
        ], $attrs);

        return new Icon($name, $weight, $this, $attrs);
    }

    private function buildClass($class)
    {
        return trim(sprintf('%s %s', $this->config['class'], $class));
    }


}