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
 * LocalCoast LocalBot Event Handler
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use \LocalCoast\LocalBot\Event\Event;
use \LocalCoast\LocalBot\EventHandler\Condition;

class EventHandler
{
    protected $_conditions = array();

    protected $_handler;

    protected $_name;

    protected $_eventName;

    /**
     * Class constructor
     *
     * @param   array   $handler
     * @param   array   $conditions
     */
    public function __construct($handler, $eventName = null, $conditions = array())
    {
        $this->_name = uniqid('', true);

        $this->_handler = $handler;

        $this->_eventName = $eventName;

        foreach ($conditions as $condition) {
            if ($condition instanceof Condition) {
                $this->_conditions[] = $condition;
            }
        }
    }

    /**
     * Does the event meet all of the requirements?
     *
     * @param   \LocalCoast\LocalBot\Event\Event $event
     *
     * @return  boolean
     */
    public function matchesEvent($event)
    {
        return $this->_matchesEvent($event);
    }


    /**
     * Returns an array of conditions for this event
     *
     * @return  array
     */
    public function getConditions()
    {
        return $this->_conditions;
    }

    /**
     * Does the event meet all of the requirements?
     *
     * @param   \LocalCoast\LocalBot\Event\Event $event
     *
     * @return  boolean
     */
    protected function _matchesEvent(Event $event)
    {
        foreach ($this->getConditions() as $condition) {
            if (!$condition->matchesEvent($event)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Adds a condition to the event handler
     *
     * @param   \Condition  $condition
     * @param   boolean     $atStart
     *
     * @return  \LocalCoast\LocalBot\EventHandler
     */
    public function addCondition($condition, $atStart = false)
    {
        if ($atStart) {
            array_unshift($this->_conditions, $condition);
        } else {
            $this->_conditions[]  = $condition;
        }

        return $this;
    }

    /**
     * Returns the handler for this event handler
     *
     * @return  \LocalCoast\LocalBot\Plugin
     */
    public function getHandler()
    {
        return $this->_handler;
    }

    /**
     * Returns the name of this event
     *
     * @return  string
     */
    public function getEventName()
    {
        return $this->_eventName;
    }

    /**
     * Runs the handler of the event
     *
     * @return  \LocalCoast\LocalBot\Event\Response
     */
    public function run($event)
    {
        $this->getHandler()->setEvent($event)->handleEvent($this->getEventName());

        return $this->getHandler()->getResponse();
    }

}