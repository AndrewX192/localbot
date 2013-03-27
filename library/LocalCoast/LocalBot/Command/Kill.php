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
 * LocalCoast LocalBot Kill Command
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use \LocalCoast\LocalBot\Command;

class Kill extends Command
{
    public function __construct($nick, $message)
    {
        $this->setTarget($nick)
             ->setMessage($message);
    }
}
