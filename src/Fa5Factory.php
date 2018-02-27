<?php

namespace Depsimon\BladeFa5;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Fa5Factory
{

    private $files;
    private $config = [
        'weight' => 'far'
    ];

    const WEIGHT_SPRITESHEETS = [
        'far' => 'fa-regular.svg',
        'fal' => 'fa-light.svg',
        'fas' => 'fa-solid.svg',
        'fab' => 'fa-brands.svg'
    ];

    public function __construct($config = [], $filesystem = null)
    {
        $this->config = Collection::make(array_merge($this->config, $config));
        $this->files = $filesystem ?: new Filesystem;
    }

    public function registerBladeTag()
    {
        Blade::directive('fa5', function ($expression) {
            return "<?php echo e(fa5_icon($expression)); ?>";
        });
    }

    public function spritesheets(...$weights)
    {
        $weights = array_flatten($weights);

        if (empty($weights)) {
            $weights = [$this->config['weight']];
        }

        return new HtmlString(
            sprintf(
                '<div style="height: 0; width: 0; position: absolute; visibility: hidden;">%s</div>',
                $this->spritesheetsContents($weights)
            )
        );
    }

    private function spritesheetsContents($weights)
    {
        $contents = '';
        foreach ($weights as $weight) {
            $contents .= $this->spritesheetContent($weight);
        }

        return $contents;
    }

    private function spritesheetContent($weight)
    {
        return cache()->rememberForever("fa5-{$weight}-spritesheet", function () use ($weight) {
            $dom = new \DomDocument;
            $dom->loadXML(file_get_contents($this->spritesheetPath($weight)));

            foreach ($dom->getElementsByTagName('symbol') as $symbol) {
                $symbol->setAttribute('id', $weight . '-' . $symbol->getAttribute('id'));
            }

            return $dom->saveHTML();
        });
    }

    public function spritesheetPath($weight)
    {
        return str_finish($this->config->get('spritesheets_path', function () {
            throw new Exception('No spritesheets_path set!');
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