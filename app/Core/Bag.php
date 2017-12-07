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
    /**
     * @var array
     */
    private $collection;

    /**
     * Bag constructor.
     *
     * @param array $collection
     */
    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->collection;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->collection);
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return array_key_exists($key, $this->collection) ? $this->collection[$key] : null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->collection[$key] = $value;
    }

    /**
     * @param array $collection
     */
    public function replace(array $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param array $collection
     */
    public function merge(array $collection)
    {
        $this->collection = array_merge($this->collection, $collection);
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        unset($this->collection[$key]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }
}