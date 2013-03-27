<?php
/**
 * LocalCoast Networks IRC Bot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

/**
 * LocalCoast Networks LocalBot Event
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
namespace LocalCoast\LocalBot\Event;

class Event
{
    /**
     * The raw event from the server
     *
     * @var string
     */
    protected $_rawEvent;

    /**
     * The "from" bit of the message
     *
     * @var string
     */
    protected $_source;

    /**
     * The ident of the user sending the message
     *
     * @var string
     */
    protected $_ident;

    /**
     *
     * @var string
     */
    protected $_nick;

    /**
     *
     * @var string
     */
    protected $_hostname;

    /**
     *
     * @var string
     */
    protected $_command;

    /**
     * Is this a numeric command?
     *
     * @var boolean
     */
    protected $_isNumeric = false;

    /**
     *
     * @var string
     */
    protected $_channel;

    /**
     * Is this event caused by a user?
     *
     * @var boolean
     */
    protected $_isFromUser = true;

    /**
     * The message for this event
     *
     * @var string
     */
    protected $_message;

    /**
     * The Event constructor
     *
     * @param   string  $eventString
     */
    public function __construct($eventString)
    {
        if (0 == strlen($eventString)) {
            return;
        }

        $this->_rawEvent = $eventString;

        $eventParts = explode(' ', $eventString, 4);

        $this->_source    = substr($eventParts[0], 1);

        $matches = array();

        if (2 == count($eventParts)) {
            $this->_command = $eventParts[0];

            $this->_source = substr($eventParts[1], 1);

            return;
        } else if (3 == count($eventParts)) {
            $this->_command = $eventParts[1];

            if (in_array($this->_command, array('JOIN'))) {
                $this->_channel = substr($eventParts[2], 1);
            } else {
                $this->_channel = $eventParts[2];
            }

        } else if (4 == count($eventParts)) {
            $this->_message = substr($eventParts[3], 1);
            $this->_command = $eventParts[1];

            if (in_array($this->_command, array(353))) {
                $this->_channel = substr($this->_message, 1, (strpos($this->_message, ':') - 2));

                if (':' != substr($this->_message, 1, 1)) {
                    $this->_message = substr($this->_message, (strpos($this->_message, ':') + 1));
                }
            }
        }

        // Handles messages from users (as opposed to servers)
        if (preg_match('/(.*)!(.*)@(.*)/', $this->_source, $matches)) {
            $this->setNick($matches[1]);
            $this->setIdent($matches[2]);
            $this->setHostname($matches[3]);

            $this->_isFromUser  = true;
        } else {
            $this->_isFromUser  = false;
        }

        $command    = $eventParts[1];

        if (is_numeric($command)) {
            $this->_isFromUser = false;

            $this->_numeric = true;
        }

        $this->_command = $eventParts[1];

    }

    /**
     * Returns the raw event string sent by the server
     *
     * @return  string
     */
    public function getRawEventString()
    {
        return $this->_rawEvent;
    }

    /**
     * Sets the network the event occured on
     *
     * @param   \LocalCoast\LocalBot\Network\Network    $network
     */
    public function setNetwork($network)
    {
        $this->_network = $network;
    }

    /**
     * Returns the network the event occured on
     *
     * @return  \LocalCoast\LocalBot\Network\Network
     */
    public function getNetwork()
    {
        return $this->_network;
    }

    /**
     * Sets the ident
     *
     * @param   string  $ident
     *
     * @return  \LocalCoast\LocalBot\Event
     */
    public function setIdent($ident)
    {
        $this->_ident = $ident;

        return $this;
    }

    /**
     * Return's the ident of the event creator
     *
     * @return  string
     */
    public function getIdent()
    {
        return $this->_ident;
    }

    /**
     * Sets the nickname
     *
     * @param   string  $nick
     */
    public function setNick($nick)
    {
        $this->_nick = $nick;

        return $this;
    }

    /**
     * Returns the nickname of the event creator
     *
     * @return  string
     */
    public function getNick()
    {
        return $this->_nick;
    }

    /**
     * Returns the hostname of the event creator
     *
     * @return  string
     */
    public function getHostname()
    {
        return $this->_hostname;
    }

    /**
     * Sets the hostname
     *
     * @param   string  $hostname
     *
     * @return  \LocalCoast\LocalBot\Event
     */
    public function setHostname($hostname)
    {
        $this->_hostname = $hostname;

        return $this;
    }

    /**
     * Returns the channel
     *
     * @return  string
     */
    public function getChannel()
    {
        return $this->_channel;
    }

    /**
     * Sets the channel
     *
     * @param   string  $channel
     *
     * @return  \LocalCoast\LocalBot\Event
     */
    public function setChannel($channel)
    {
        $this->_channel = $channel;

        return $this;
    }

    /**
     * Is this a user message?
     *
     * @return  boolean
     */
    public function isUserMessage()
    {
        return $this->isFromUser();
    }

    /**
     * Is this from a user?
     *
     * @return type
     */
    public function isFromUser()
    {
        return $this->_isFromUser;
    }

    public function isFromServer()
    {
        return !$this->isFromUser();
    }

    public function isChannelEvent()
    {
        return $this->_isChannelEvent;
    }

    public function getTarget()
    {
        return $this->_target;
    }

    public function isNumeric()
    {
        return $this->_isNumeric;
    }

    /**
     * Returns the command numeric
     *
     * @return  int
     *
     * @throws \LocalCoast\LocalBot\Exception if the command is not a numeric.
     */
    public function getNumeric()
    {
        if ($this->isNumeric()) {
            return (int) $this->_command;
        }

        throw new \LocalCoast\LocalBot\Exception(
            'The command is not a numeric'
        );
    }

    /**
     * Returns the command
     *
     * @return  string
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Returns the message
     *
     * @return  string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Returns the source of the event
     *
     * @return  string
     */
    public function getSource()
    {
        return $this->_source;
    }
}