<?php

/*
 * @file
 *
 * BladeEngine
 */

namespace Hunter\Engine;

use Hunter\Engine\Blade\Loader;
use Hunter\Engine\Blade\Environment;

class BladeEngine implements EngineInterface {

    /**
     * 模版文件
     */
    protected $template;

    /**
     * 模版数据
     */
    protected $parameters = array();

    /**
     * 整体环境包
     */
    protected $environment;

    /**
     * Blade加载器
     */
    protected $loader;

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

    /**
     * 析构函数
     */
    public function __construct($theme_path, $cache_path) {
        $this->theme_path = $theme_path;
        $this->cache_path = $cache_path;
        $this->loader = new Loader($this->theme_path, $this->cache_path);
        $this->environment = new Environment($this->loader, array('theme_path' => $theme_path, 'cache_path' => $this->cache_path));
    }

    /**
     * 渲染模版
     */
    public function render($name, array $parameters = array()) {
        $this->setTemplate($name);
        $this->setParameters($parameters);
        return $this->environment->render($name, $parameters);
    }

    /**
     * 渲染并直接输出
     */
    public function display($name, array $parameters = array()) {
        $this->environment->display($name, $parameters);
    }

    /**
     * 模版是否存在
     */
    public function exists($name) {
        return $this->environment->exists((string) $name);
    }

    /**
     * 设置模版
     */
    public function setTemplate($name) {
        $this->template = $name;
        return $this;
    }

    /**
     * 设置数据
     */
    public function setParameters(array $parameters = array()) {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * 设置数据
     */
    public function setParameter($key, $value = null) {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * 获取数据
     */
    public function getParameters($names = null) {
        if ($names && is_array($names)) {
            foreach ($names as $name) {
                $return[$name] = isset($this->parameters[$name]) ? $this->parameters[$name] : null;
            }
            return $return;
        } elseif (!isset($names)) {
            return $this->parameters;
        }
    }

    /**
     * 获取数据
     */
    public function getParameter($name, $default = null) {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }

    /**
     * 获取Loader
     */
    public function getLoader() {
        return $this->loader;
    }

    /**
     * 添加全局变量
     */
    public function addGlobal($key, $value) {
        $this->environment->addGlobal($key, $value);
        return $this;
    }

    /**
     * 获取Environment
     */
    public function getEnvironment() {
        return $this->environment;
    }

}
