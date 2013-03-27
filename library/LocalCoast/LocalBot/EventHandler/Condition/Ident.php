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
 * LocalCoast LocalBot Ident Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use LocalCoast\LocalBot\EventHandler\Condition;

class Ident extends Condition
{
    /**
     * The ident to match the event against
     *
     * @var string
     */
    protected $_ident;

    protected $_isCaseSensitive;

    /**
     * Ident Condition Constructor
     *
     * @param   string|array    $ident
     * @param   boolean         $isCaseSensitive
     */
    public function __construct($ident, $isCaseSensitive = false)
    {
        if (!is_array($ident)) {
            if (!$isCaseSensitive) {
                $ident = strtolower($ident);
            }
        } else {
            if (!$isCaseSensitive) {
                array_walk($ident, function(&$value, $key) {
                    $value = strtolower($value);
                });
            }
        }

        $this->_ident = $ident;

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
        $otherIdent = $event->getIdent();

        if (!$this->_isCaseSensitive) {
            $otherIdent = strtolower($otherIdent);
        }

        if (!is_array($this->_ident)) {
            return ($this->_ident == $otherIdent);
        }

        return in_array($otherIdent, $this->_ident);
    }

}