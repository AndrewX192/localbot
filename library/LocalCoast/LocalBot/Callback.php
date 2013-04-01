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

/**
 * LocalCoast LocalBot Callback
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license
 */
final class Callback
{
    /**
     * The class to use
     *
     * @var object
     */
    private $_class;

    /**
     * The method name to call
     * @var type
     */
    private $_method;

    public function __construct($class, $method)
    {
        $this->setClass($class)->setMethod($method);
    }

    /**
     * Sets the class to call the method on
     *
     * @param   object  $class
     *
     * @return \LocalCoast\LocalBot\Callback
     */
    public function setClass($class)
    {
        if (!is_object($class)) {
            throw new \LocalCoast\LocalBot\Exception(
                "provided argument is not an instance of a class"
            );
        }

        $this->_class = $class;

        return $this;
    }

    /**
     * Returns an instance of the class that will be used
     *
     * @return object
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * Sets the method to invoke
     *
     * @param   string  $method
     *
     * @return \LocalCoast\LocalBot\Callback
     */
    public function setMethod($method)
    {
        $this->_method = $method;

        return $this;
    }

    /**
     * Returns the method to call
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    public function invoke()
    {

    }
}