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
 * Contains a LocalCoast LocalBot Connection
 *
 * @category    LocalCoast
 * @package     LocalCoast_LocalBot
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
abstract class Connection implements \LocalCoast\LocalBot\ConnectionInterface
{
    protected $_resource;

    private $_options;


    protected $_network;

    protected $_server;

    public function __construct()
    {}

    /**
     * Sets an array of options on the connection
     *
     * @param   array   $options
     */
    public function setOptions(array $options)
    {
        $this->_options = $options;

        return $this;
    }

    /**
     * Returns an array of options for the connection
     *
     * @return  array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Sets an option
     *
     * @param   string  $name
     * @param   mixed   $option
     *
     * @return  \LocalCoast\LocalBot\Connection
     */
    public function setOption($name, $option)
    {
        $this->_options[$name] = $option;

        return $this;
    }

    /**
     * Returns the vaue of an option
     *
     * @param   mixed   $name
     *
     * @return  mixed
     */
    public function getOption($name)
    {
        return $this->_options[$name];
    }

    /**
     * Sets the resource for the connection
     *
     * @param   resource    $resource
     */
    public function setResource($resource)
    {
        $this->_resource = $resource;

        return $this;
    }

    /**
     * Returns the connection resource
     *
     * @return  \LocalCoast\LocalBot\Connection
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     *
     * @param   \LocalCoast\LocalBot\Network\Network    $network
     *
     * @return  \LocalCoast\LocalBot\Connection
     */
    public function setNetwork($network)
    {
        $this->_network = $network;

        return $this;
    }

    /**
     * Returns the network of this connection
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function getNetwork()
    {
        return $this->_network;
    }

    /**
     * Sets the server to connect to
     *
     * @param   \LocalCoast\LocalBot\Network\Server $server
     *
     * @return  \LocalCoast\LocalBot\Connection
     */
    public function setServer($server)
    {
        $this->_server = $server;

        $this->setOptions($server->toArray());

        return $this;
    }

    /**
     * Returns the server this connection is for
     *
     * @return  \LocalCoast\LocalBot\Network\Server
     */
    public function getServer()
    {
        return $this->_server;
    }

}
