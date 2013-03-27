<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot\Network;

/**
 * LocalCoast LocalBot Metwork Server
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

class Server
{
    /**
     * The server hostname to connect to
     *
     * @var string
     */
    protected $_hostname;

    /**
     * The port number to connect on
     *
     * @var int
     */
    protected $_port;

    /**
     * Does the server require SSL?
     *
     * @var boolean
     */
    protected $_ssl;

    public function __construct($hostname = '', $port = 6667, $ssl = false)
    {
        $this->_hostname    = $hostname;
        $this->_port        = $port;
        $this->_ssl         = (bool) $ssl;
    }

    /**
     * Sets the hostname for this server
     *
     * @param   string  $hostname
     *
     * @return  \LocalCoast\LocalBot\Network\Server
     */
    public function setHostname($hostname)
    {
        $this->_hostname = $hostname;

        return $this;
    }

    /**
     * Returns the hostname of this server
     *
     * @return  string
     */
    public function getHostname()
    {
        return $this->_hostname;
    }

    /**
     * Sets the port number
     *
     * @param   int $port
     *
     * @return  \LocalCoast\LocalBot\Network\Server
     */
    public function setPort($port)
    {
        $this->_port = $port;

        return $this;
    }

    /**
     * Returns the port to connect to the IRC network
     *
     * @return  int
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
     * Returns whether or not the server requires SSL
     *
     * @return  boolean
     */
    public function requiresSsl()
    {
        return $this->_ssl;
    }

    /**
     * Sets whether or not the server requires SSL
     *
     * @param   boolean $ssl
     *
     * @return  \LocalCoast\LocalBot\Network\Server
     */
    public function setSsl($ssl)
    {
        $this->_ssl = (bool) $ssl;

        return $this;
    }

    /**
     * Sets the server information from an array
     *
     * @param   array   $server
     *
     * @return  \LocalCoast\LocalBot\Network\Server
     */
    public function setFromArray($server)
    {
        $mappings = array(
            'hostname'  => '_hostname',
            'port'      => '_port',
            'ssl'       => '_ssl',
        );

        foreach ($mappings as $k => $v) {
            if (array_key_exists($k, $server)) {
                $this->{$v} = $server[$k];
            }
        }

        return $this;
    }

    /**
     * Converts this server to an array
     *
     * @return  array
     */
    public function toArray()
    {
        $server = array();

        $mappings = array(
            'hostname'  => '_hostname',
            'port'      => '_port',
            'ssl'       => '_ssl',
        );

        foreach ($mappings as $k => $mapping) {
            $server[$k] = $this->{$mapping};
        }

        return $server;
    }

}