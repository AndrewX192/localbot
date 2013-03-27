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
 * LocalCoast LocalBot Nick Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\Condition;

class Command extends Condition
{
    /**
     *
     * @var type
     */
    protected $_command;

    /**
     *
     * @param   string  $command
     */
    public function __construct($command)
    {
        $this->_command = strtoupper($command);
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
        return ($this->_command == $event->getCommand());
    }

}