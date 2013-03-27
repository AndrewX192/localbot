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
 * LocalCoast LocalBot Metwork
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

class Network
{
    /**
     * The name of the network
     *
     * @var string
     */
    protected $_name;

    protected $_nick;

    protected $_ident;

    /**
     * An array of servers
     *
     * @var array
     */
    protected $_servers;

    protected $_channels;

    /**
     * The network class constructor
     *
     * @param   string  $name
     */
    public function __construct($name)
    {
        $this->_servers     = array();
        $this->_channels    = array();

        $this->setName($name);
    }

    /**
     * Sets the name of the network
     *
     * @param   string  $name
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Returns the name of the network
     *
     * @return  string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the nick to connect to this network with
     *
     * @param   string  $nick
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function setNick($nick)
    {
        $this->_nick = $nick;

        return $this;
    }

    /**
     * Returns the nick to connect to this network with
     *
     * @return  string
     */
    public function getNick()
    {
        return $this->_nick;
    }

    /**
     * Sets the network options from an array
     *
     * @param   array   $network
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function setFromArray($network)
    {
        $mappings = array(
            'name'      => '_name',
            'nick'      => '_nick',
            'ident'     => '_ident',
        );

        foreach ($mappings as $k => $v) {
            if (array_key_exists($k, $network)) {
                $this->{$v} = $network[$k];
            }
        }

        return $this;
    }

    /**
     * Adds a server to the network
     *
     * @param   \LocalCoast\LocalBot\Network\Server $server
     *
     * @return  \LocalCoast\LocalBot\Network
     */
    public function addServer($server)
    {
        $this->_servers[] = $server;

        return $this;
    }

    /**
     * Gets server in a given position in the server list
     *
     * @param   int $position
     */
    public function getServer($position)
    {
        return $this->_servers[$position];
    }

    /**
     * Removes the server from the network
     *
     * @param   \LocalCoast\LocalBot\Network\Server $server
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function removeServer($server)
    {
        unset ($this->_servers[array_search($server, $this->_servers)]);

        return $this;
    }

    /**
     * Returns whether or not the channel exists on this network
     *
     * @param   string  $channel
     *
     * @return  boolean
     */
    public function hasChannel($channel)
    {
        return array_key_exists($channel, $this->_channels);
    }

    /**
     * Adds a channel to this network
     *
     * @param   \LocalCoast\LocalBot\Channel\Channel    $channel
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function addChannel($channel)
    {
        $this->_channels[$channel->getName()] = $channel;

        return $this;
    }

    public function getChannel($channel)
    {
        if ($this->hasChannel($channel)) {
            return $this->_channels[$channel];
        }
    }

    public function getChannelNames()
    {
        return array_keys($this->_channels);
    }

    public function getChannels()
    {
        return $this->_channels;
    }

    public function removeChannel($channel)
    {
        unset($this->_channels[$channel]);

        return $this;
    }

}