<?php

namespace kiwi;

class Meta extends Model
{
    /**
     * Fetch a meta value.
     *
     * @param string $property
     *
     * @return mixed
     */
    public static function get($property)
    {
        return static::$query->select('site_meta', 'value', ['key', '=', $property]);
    }

    public static function getAll()
    {
        $result = static::$query->selectAll('site_meta');
        $app = [];

        foreach ($result as $row) {
            $app[$row['key']] = $row['value'];
        }

        return $app;
    }
}
