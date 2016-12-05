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
 use Hunter\Engine\BladeEngine;

 $engine = new BladeEngine($path, $cachePath);
 $variables['name'] = 'lanyulu';

 return $engine->setTemplate('hello.html')->setParameters($variables)->render('hello.html', $variables);
 
```

Documentation: [http://laravel.com/docs/5.3/blade](http://laravel.com/docs/5.3/blade)
