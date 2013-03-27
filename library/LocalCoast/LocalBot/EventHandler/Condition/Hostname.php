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
 * LocalCoast LocalBot Hostname Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\Condition;

class Hostname extends Condition
{
    protected $_hostname;

    /**
     * Hostname Condition Constructor
     *
     * @param   string|array    $hostname
     * @param   boolean         $isCaseSensitive
     */
    public function __construct($hostname, $isCaseSensitive = false)
    {
        if (!is_array($hostname)) {
            $hostname = strtolower($hostname);
        } else {
            array_walk($hostname, function(&$value, $key) {
                $value = strtolower($value);
            });
        }

        $this->_hostname = $hostname;
    }

    /**
     * Does the event match this condition?
     *
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     *
     * @return  boolean
     */
    public function _matchesEvent($event)
    {
        $otherHostname = strtolower($event->getHostname());

        if (!is_array($this->_hostname)) {
            return ($this->_hostname == $otherHostname);
        }

        return in_array($otherHostname, $this->_hostname);
    }

}