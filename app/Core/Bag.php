<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 05.12.2017
 * Time: 17:36
 */

namespace NTSchool\Phpblog\Core;


class Bag
{
    private $collection;

    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    public function getAll()
    {
        return $this->collection;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->collection);
    }

    public function get($key)
    {
        return array_key_exists($key, $this->collection) ? $this->collection[$key] : null;
    }

    public function set($key, $value)
    {
        $this->collection[$key] = $value;
    }

    public function replace(array $collection)
    {
        $this->collection = $collection;
    }

    public function merge(array $collection)
    {
        $this->collection = array_merge($this->collection, $collection);
    }

    public function remove($key)
    {
        unset($this->collection[$key]);
    }

    public function count()
    {
        return count($this->collection);
    }
}