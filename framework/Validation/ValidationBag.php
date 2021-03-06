<?php

namespace kiwi\Http;

class ValidationBag implements \ArrayAccess
{
    /**
     * Errors set by ArrayAccess or magic methods.
     *
     * @var array
     */
    public $errors = [];

    /**
     * Create a new ValidationBag instance.
     */
    public function __construct()
    {
        if ($errors = resolve('session')->get('errors')) {
            $this->errors = $errors;
            resolve('session')->unset('errors');
        }

        return $this;
    }

    /**
     * Check if an offset exists when using ArrayAccess.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return in_array($offset, $this->errors);
    }

    /**
     * Get an error when using ArrayAccess.
     *
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->errors[$offset] ?? null;
    }

    /**
     * Set an error when using ArrayAccess.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->errors[] = $value;

            return;
        }

        $this->errors[$offset][] = $value;
    }

    /**
     * Unset an error when using ArrayAccess.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->errors[$offset]);
    }

    /**
     * Dynamically get an error on the object.
     *
     * @param mixed $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (array_key_exists($property, $this->errors)) {
            return $this->errors[$property];
        }
    }

    /**
     * Dynamically set an error on the object.
     *
     * @param mixed $property
     * @param mixed $value
     *
     * @return void
     */
    public function __set($property, $value)
    {
        $this->errors[$property][] = $value;
    }

    /**
     * Fancy constructor.
     *
     * @return self
     */
    public static function make()
    {
        return new self();
    }
}
