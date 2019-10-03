<?php

namespace SolarWinds\Chess\Helpers;

class EnumHelper
{
    private static $_instance = false;
    private static $_constants = [];
    private static $_childClassName;

    private $_id;

    private function __construct($_id)
    {
        $this->_id = $_id;
    }

    private static function getConstants() {
        $childClass = new \ReflectionClass(self::$_childClassName);
        return $childClass->getConstants();
    }

    private static function initialise()
    {
        if (self::$_instance) {
            return;
        }

        self::$_childClassName = get_called_class();
        self::$_constants = self::getConstants();
    }

    public function __toString()
    {
        return (string)$this->_id;
    }

    public static function __callStatic($name, $arguments)
    {
        self::initialise();

        if (array_key_exists($name, self::$_constants)) {
            return new self::$_childClassName(self::$_constants[$name]);
        }

        throw new \ErrorException("Undefined ENUM constant '{$name}'");
    }
}