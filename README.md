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

## Configuration

Inside `config/blade-fa5.php`, you can specify the spritesheets path, the default weight and the default classes for icons.

```php
<?php

return [
    'spritesheets_path' => 'resources/assets/svg/',
    'weight' => 'far',
    'class' => 'icon inline-block fill-current',
];
```

## Basic usage

First, make sure to include the spritesheets that you'll use in your template with the `fa5_spritesheets()` helper:

```html
<!-- layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
    <head><!-- ... --></head>
    <body>
        <!-- ... -->

        {{ fa5_spritesheets('far', 'fas', 'fal', 'fab') }}
    </body>
</html>
```

To insert a Font Awesome icon in your template, simply use the `@fa5` Blade directive, passing the name of the icon and optionally the weight and then any additional classes:

```html
@fa5('cog')
@fa5('facebook', 'fab')
@fa5('facebook', 'fab', 'text-blue')
@fa5('spinner', 'fal', 'text-grey', ['spin'])
```

## Credits

- [Simon Depelchin](https://github.com/depsimon)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
