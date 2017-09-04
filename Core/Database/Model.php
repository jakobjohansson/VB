<?php

namespace kiwi\Database;

use kiwi\Container;

abstract class Model implements \ArrayAccess
{

    public $attributes = [];

    public static function builder()
    {
        return new Builder(Container::resolve('connection'));
    }

    public function offsetExists($offset)
    {
        return in_array($this->attributes, $offset);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->attributes[] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }
}
