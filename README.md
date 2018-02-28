# Blade FontAwesome 5

Easily inline Font Awesome 5 icons in your Blade templates.
Heavily inspired by the great [adamwathan/blade-svg].

## Installation

You can install this package via Composer by running this command in your terminal in the root of your project:

```bash
composer require depsimon/blade-fa5
```

## Getting started

Publish the Blade Font Awesome 5 config file:

```bash
php artisan vendor:publish --provider="Depsimon\BladeFa5\BladeFa5ServiceProvider"
```

Download the [Font Awesome 5](https://fontawesome.com/) latest version (Free or Pro) and put the SVG sprites in your `public/svg` directory.

## Configuration

Inside `config/blade-fa5.php`, you can specify the spritesheets directory, the default weight and the default classes for icons.

```php
<?php

return [
    'spritesheets_url' => 'svg/',
    'weight' => 'far',
    'class' => 'icon inline-block fill-current',
];
```

## Basic usage

You can insert an icon anywhere in your template with the `@fa5` Blade directive.
You pass the name, then the weight, the classes and any additional classes:

```html
@fa5('cog')
@fa5('user', 'fas') <!-- Weight is "solid" -->
@fa5('facebook', 'fab', 'text-blue') <!-- Weight is "brands" and apply "text-blue" class -->
@fa5('spinner', 'fal', 'text-grey', ['spin']) <!-- Add the "spin" attribute -->
```

## Credits

- [Simon Depelchin](https://github.com/depsimon)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
