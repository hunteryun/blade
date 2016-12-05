# Blade
A Blade Template Engine for Drupal.
### Installation

With Composer, you just need to run

``` sh
composer require hunteryun/blade
```

If you haven't use composer, you should add all the files in folder `src` to your project folder,
and then `require` them in your code.


### Usage

```php
<?php
 $engine = new BladeEngine($path, $cachePath);
 $variables['name'] = 'lanyulu';

  return $engine->setTemplate('hello.html')->setParameters($variables)->render('hello.html', $variables);
```

You can enjoy almost all the features of blade with this extension.
However, remember that some of exclusive features are removed.

Documentation: [http://laravel.com/docs/5.3/blade](http://laravel.com/docs/5.3/blade)
