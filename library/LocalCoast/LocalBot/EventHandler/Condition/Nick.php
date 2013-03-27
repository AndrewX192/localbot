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

class Nick extends Condition
{
    protected $_nick;

    protected $_isCaseSensitive;

    /**
     * Nick Condition Constructor
     *
     * @param   string|array    $nick
     * @param   boolean         $isCaseSensitive
     */
    public function __construct($nick, $isCaseSensitive = false)
    {
        if (!is_array($nick)) {
            if (!$isCaseSensitive) {
                $nick = strtolower($nick);
            }
        } else {
            if (!$isCaseSensitive) {
                array_walk($nick, function(&$value, $key) {
                    $value = strtolower($value);
                });
            }
        }

        $this->_nick = $nick;

        $this->_isCaseSensitive = $isCaseSensitive;
    }

    /**
     * Does the condition match this event?
     *
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     *
     * @return  boolean
     */
    public function _matchesEvent($event)
    {
        $otherNick = $event->getNick();

        if (!$this->_isCaseSensitive) {
            $otherNick = strtolower($otherNick);
        }

        if (!is_array($this->_nick)) {
            return ($this->_nick == $otherNick);
        }

        return in_array($otherNick, $this->_nick);
    }

}