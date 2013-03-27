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
 * LocalCoast LocalBot Regex Condition
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
class MessageQueue
{
    protected $_queue;

    /**
     * The Message Queue Constructor
     */
    public function __construct()
    {
        $this->_queue = array();
    }

    /**
     * Offers a new message to the message queue
     *
     * @param   string  $message
     *
     * @return  \LocalCoast\LocalBot\MessageQueue
     */
    public function offer($message)
    {
        $this->_queue[] = $message;

        return $this;
    }

    /**
     * Returns the first element of the Queue
     *
     * @return  string
     */
    public function poll()
    {
        return reset($this->_queue);
    }

    /**
     * Returns the number of messages in the queue
     *
     * @return  int
     */
    public function count()
    {
        return count($this->_queue);
    }

    /**
     * Returns whether or not the message queue is empty
     *
     * @return  boolean
     */
    public function isEmpty()
    {
        return (0 === $this->count());
    }
}