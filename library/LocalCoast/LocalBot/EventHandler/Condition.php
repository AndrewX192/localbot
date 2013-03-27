<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot\EventHandler;

/**
 * LocalCoast LocalBot Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\ConditionInterface;

abstract class Condition implements ConditionInterface
{
    /**
     * Whether or not condition is negated
     *
     * @var boolean
     */
    protected $_negated = false;

    /**
     * Does the condition match this event?
     *
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     *
     * @return  boolean
     */
    public function matchesEvent($event)
    {
        $matches = $this->_matchesEvent($event);

        if ($this->isNegated()) {
            $matches = !$matches;
        }

        return $matches;
    }

    /**
     * Returns whether or not the condition is negated (reversed)
     *
     * @return  boolean
     */
    public function isNegated()
    {
        return $this->_negated;
    }

    /**
     * Negates the condition
     *
     * @return  \LocalCoast\LocalBot\EventHandler\Condition
     */
    public function negate()
    {
        $this->_negated = true;

        return $this;
    }
}
