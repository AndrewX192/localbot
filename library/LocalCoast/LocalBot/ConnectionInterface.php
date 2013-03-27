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
 * Contains a LocalCoast LocalBot Connection Interface
 *
 * @category    LocalCoast
 * @package     LocalCoast_LocalBot
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

interface ConnectionInterface
{
    /**
     * Connects to a server with the given options.
     */
    public function connect($options);

    /**
     * Reads the network buffer
     *
     * @return  string
     */
    public function read();

    /**
     * Writes to the network buffer
     *
     * @param   string  $buffer
     */
    public function write($buffer);

    /**
     * Closes the connection
     *
     * @return  \LocalCoast\LocalBot\Connection
     */
    public function close();
}
