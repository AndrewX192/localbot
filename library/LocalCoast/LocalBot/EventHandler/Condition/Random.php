<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot\EventHandler\Condition;

/**
 * LocalCoast LocalBot Random Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\Condition;

class Random extends Condition
{
    /**
     * The number to divide by
     *
     * @var int
     */
    protected $_divisor;

    /**
     * Random Condition Constructor
     *
     * @param   int $divisor (1/$divisor chance of the condition being true)
     */
    public function __construct($divisor)
    {
        $this->_divisor = $divisor;
    }

    /**
     * Does the condition match this event?
     *
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     *
     * @return  boolean
     */
    public function matchesEvent($event)
    {
        return (1 == rand(1, $this->_divisor));
    }
}