<?php

namespace App\App;

class Config
{
    private $configs = array();
    private static $instance;

    // Защита от создания объекта.
    private function __clone() {}
    private function __construct() {}

    /**
     * Возвращает объект конфигураций.
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
            static::init();
        }
        return static::$instance;
    }

    /**
     *  Начальная инициализация конфигураций.
     */
    private static function init()
    {
        static::$instance->set('db', require_once APP_DIR . DIRECTORY_SEPARATOR .
            'configs' . DIRECTORY_SEPARATOR .
            'db.php');
    }

    /**
     * Возвращает конфиг по ключу.
     *
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        return array_get($this->configs, $key, $default);
    }

    /**
     * Задать конфиг.
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->configs[$key] = $value;
    }

}