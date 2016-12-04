<?php

/*
 * @file
 *
 * Theme
 */
 
namespace Hunter\Engine\Templating;

use Hunter\Engine\Templating\BladeEngine;
use Hunter\Engine\Templating\Blade\Loader;
use Hunter\Engine\Templating\Blade\Environment;

class Theme {

    /*
     * 模板存放路径
     *
     * @var array
     */
    protected $theme_path = array();

    /*
     * 缓存路径
     *
     * @var array
     */
    protected $cache_path;

    public function __construct($theme_path, $cache_path) {
      $this->theme_path = $theme_path;
      $this->cache_path = $cache_path;
    }

    /*
     * 初始化engine实例
     */
    public function initEngine() {
        $loader = new Loader($this->theme_path, $this->cache_path);
        $env    = new Environment($loader, array());
        $engine = new BladeEngine($env);

        return $engine;
    }

}
