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
 * LocalCoast LocalBot Channel Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\Condition;

class Channel extends Condition
{
    /**
     * The name of the channel
     *
     * @var string
     */
    protected $_channel;

    /**
     * Channel Condition Constructor
     *
     * @param   string  $channel
     */
    public function __construct($channel)
    {
        $this->_channel = $channel;
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
        return ($this->_channel == $event->getChannel());
    }

}