<?php

namespace Core;

class Config
{

    private $settings = [];
    private static $_instance;

    public static function getInstance($file)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    public function __construct($file)
    {
        $this->settings = require($file);
    }

    /**
     * If the key is not set, return null. Otherwise, return the value of the key.
     * 
     * @param key The key of the setting you want to get.
     * 
     * @return The value of the key in the array.
     */
    public function get($key)
    {

        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
