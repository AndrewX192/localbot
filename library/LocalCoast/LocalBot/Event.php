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
namespace LocalCoast\LocalBot;

class Event
{

    /**
     * The "from" bit of the message
     *
     * @var string
     */
    protected $_from;

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
    protected $_isUserMessage = true;

    public function __construct($eventString)
    {
        if (0 == strlen($eventString)) {
            return;
        }

        $eventParts = explode(' ', $eventString, 4);

        $this->_from    = substr($eventParts[0], 1);

        $matches = array();

        // Handles messages from users (as opposed to servers)
        if (preg_match('/(.*)!(.*)@(.*)/', $this->_from, $matches)) {
            $this->setNick($matches[1]);
            $this->setIdent($matches[2]);
            $this->setHostname($matches[3]);

            $this->_isUserMessage = true;
        } else {
            $this->_isUserMessage = false;
        }

        $command    = $eventParts[1];

        if (is_numeric($command)) {
            $this->_isUserMessage = false;

            $this->_numeric = true;
        }

        $this->_command = $eventParts[1];

        if ($this->isNumeric()) {
            var_dump($this->getNumeric());
        }

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
        return $this->_isUserMessage;
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

    public function getMessage()
    {
        return $this->_message;
    }
}