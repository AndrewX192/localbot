<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot;

abstract class Container implements \Iterator
{
    private $_container;

    public function __construct()
    {
        $this->_container = array();
    }

    /**
     * Sets the containers contents from an array
     *
     * @param   array   $array
     *
     * @throws  Exception
     */
    public function setFromArray($array)
    {
        if (!is_array($array)) {
            throw new Exception();
        }

        $this->_container = $array;
    }

    /**
     * Returns a value from the container given a key
     *
     * @param   mixed   $key
     *
     * @return  mixed
     */
    public function get($key)
    {
        return $this->_container[$key];
    }

    /**
     * Adds a value to the container given a key
     *
     * @param   mixed   $key
     * @param   mixed   $value
     *
     * @return  \LocalCoast\LocalBot\Container
     */
    public function add($key, $value)
    {
        $this->_container[$key] = $value;

        return $this;
    }

    /**
     * Removes a value from the container given a key
     *
     * @param   mixed   $key
     *
     * @return  \LocalCoast\LocalBot\Container
     */
    public function remove($key)
    {
        unset($this->_container[$key]);

        return $this;
    }

    /**
     * Returns whether or not the container has the given key
     *
     * @param   mixed   $key
     *
     * @return  boolean
     */
    public function containsKey($key)
    {
        return array_key_exists($key, $this->_container);
    }

    /**
     * Converts this container into an array
     *
     * @return  array
     */
    public function toArray()
    {
        return $this->_container;
    }

    public function rewind()
    {
        reset($this->_container);
    }

    public function current()
    {
        return current($this->_container);
    }

    public function key()
    {
        return key($this->_container);
    }

    public function next()
    {
        return next($this->_container);
    }

    public function valid()
    {
        return array_key_exists(key($this->_container), $this->_container);
    }
}