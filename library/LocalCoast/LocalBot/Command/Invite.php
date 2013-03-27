<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot\Command;

/**
 * LocalCoast LocalBot Invite Command
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use \LocalCoast\LocalBot\Command;

class Invite extends Command
{
    public function __construct($channel, $nick)
    {
        $this->setArgument($channel)
             ->setTarget($nick);
    }

    /**
     * Creates a string representing the command to send to the server.
     *
     * @return string
     */
    public function __toString()
    {
        $ret = $this->getCommand() . ' ';

        $ret .= $this->getTarget() . ' ';

        $ret .= $this->getArgument();

        return $ret;
    }
}
