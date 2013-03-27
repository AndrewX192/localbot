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
 * LocalCoast LocalBot Oper Command
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use \LocalCoast\LocalBot\Command;

class Oper extends Command
{
    public function __construct($username, $password)
    {
        $this->setArgument($username)
             ->setMessage($password);
    }


    /**
     * Creates a string representing the command to send to the server.
     *
     * @return string
     */
    public function __toString()
    {
        $ret = $this->getCommand() . ' '
            . $this->getArgument() . ' ' . $this->getMessage();

        return $ret;
    }
}
