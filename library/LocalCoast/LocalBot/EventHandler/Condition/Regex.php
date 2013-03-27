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
 * LocalCoast LocalBot Regex Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\Condition;

class Regex extends Condition
{
    /**
     * The regex to match the event against
     *
     * @var string
     */
    protected $_regex;

    /**
     * An array of matches
     *
     * @var array
     */
    protected $_matches;

    /**
     * Regex Condition Constructor
     *
     * @param   string  $regex
     */
    public function __construct($regex)
    {
        $this->_regex   = $regex;
        $this->_matches = array();
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
        return (1 === preg_match($this->_regex, $event->getRawEventString(), $this->_matches));
    }

    /**
     * Returns an array of matches from this regex
     *
     * @return  array
     */
    public function getMatches()
    {
        return $this->_matches;
    }

}