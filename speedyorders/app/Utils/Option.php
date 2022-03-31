<?php

namespace App\Utils;

use App\Models\AdminOption;

class Option
{
    private static $option;
    private static $instance;

    private function __construct()
    {
    }

    public static function __init()
    {
        if (!isset(self::$option)) {
            self::$instance = new self();
            self::$instance->_loadSetting();
        }

        //return self::$option;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', \E_USER_ERROR);
    }

    public static function get($name, $default = false)
    {
        if (!isset(self::$option)) {
            self::__init();
        }

        $name = trim($name);

        if (\array_key_exists($name, self::$option)) {
            return self::$option[$name];
        }

        //if not autoloaded get it from database
        $query = AdminOption::select('value')
            ->where('name', $name)
            ->first();

        if (!$query) {
            return $default;
        }

        if (\is_object($query)) {
            $value = $query->value;

            return self::$instance->_maybe_unserialize($value);
        }

        return $default;
    }

    public static function set($option, $value = '', $autoload = 1)
    {
        if (!isset(self::$option)) {
            self::__init();
        }

        $option = trim($option);

        if (empty($option)) {
            return false;
        }

//        if (self::get($option) === false) {

        $value = self::$instance->_maybe_serialize($value);
        $autoload = (0 === $autoload) ? 0 : 1;

        return (bool) AdminOption::updateOrCreate(
            ['name' => $option],
            ['name' => $option, 'value' => $value, 'autoload' => $autoload]
        );

//        }
        //else
        //show_error('The option <b>"'.$option.'"</b> already exists.');
    }

    public static function update($option, $newvalue)
    {
        if (!isset(self::$option)) {
            self::__init();
        }

        $option = trim($option);

        if (empty($option)) {
            return false;
        }

        $oldvalue = self::get($option);

        if ($newvalue === $oldvalue) {
            return false;
        }

        if (false === $oldvalue) {
            return self::set($option, $newvalue);
        }

        $newvalue = self::$instance->_maybe_serialize($newvalue);

        $query = AdminOption::where('name', $option)->update(['value' => $newvalue]);

        if ($query) {
            //refresh the options
            self::$instance->_loadSetting();

            return true;
        }

        return false;
    }

    private function _loadSetting()
    {
        $opt = AdminOption::select('name', 'value')->where('autoload', '1')->get();

        $option = [];
        if (\count($opt) > 0) {
            foreach ($opt as $o) {
                $option[$o->name] = $this->_maybe_unserialize($o->value);
            }
        }

        self::$option = $option;

    }

    private function _maybe_serialize($data)
    {
        if (\is_array($data) || \is_object($data)) {
            return serialize($data);
        }

        if ($this->_is_serialized($data)) {
            return serialize($data);
        }

        return $data;
    }

    private function _maybe_unserialize($original)
    {
        if ($this->_is_serialized($original)) { // don't attempt to unserialize data that wasn't serialized going in
            return @unserialize($original);
        }

        return $original;
    }

    private function _is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!\is_string($data)) {
            return false;
        }
        $data = trim($data);

        if ('N;' == $data) {
            return true;
        }
        $length = \strlen($data);
        if ($length < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        $lastc = $data[$length - 1];
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ('"' !== $data[$length - 2]) {
                    return false;
                }
                // no break
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                return (bool) preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
        }

        return false;
    }
}
