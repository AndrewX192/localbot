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
 * LocalCoast LocalBot Nick Command
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
class Nick extends Command
{
    /**
     * $nick $mode
     *
     * $channel $modes $nicks
     * @param type $target
     * @param type $modes
     */
    public function __construct($target, $arg2, $arg3 = null)
    {
        $this->setTarget($target);

        if (null !== $arg3) {
        } else {
        }
    }
}
