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
 * LocalCoast LocalBot Condition Inteface
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

interface ConditionInterface
{

    /**
     * Does the condition match this event?
     *
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     *
     * @return  boolean
     */
    public function matchesEvent($event);
}
