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
 * LocalCoast LocalBot Plugin
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use \LocalCoast\LocalBot\Event\Event;
use \LocalCoast\LocalBot\Event\Response;

abstract class Plugin
{
    /**
     * The response from this plugin
     *
     * @var \LocalCoast\LocalBot\Event\Response
     */
    protected $_response;

    /**
     * The event being handled
     *
     * @var \LocalCoast\LocalBot\Event\Event
     */
    protected $_event;

    /**
     * Sets the event to be handled
     *
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     *
     * @return  \LocalCoast\LocalBot\Plugin
     */
    public function setEvent($event)
    {
        $this->_event = $event;

        return $this;
    }

    /**
     * Returns the current event
     *
     * @return  \LocalCoast\LocalBot\Event
     */
    protected function getEvent()
    {
        return $this->_event;
    }

    /**
     * Returns a new unregistered event handler
     *
     * @param   string  $name
     *
     * @return  \LocalCoast\LocalBot\EventHandler
     */
    protected function getNewEventHandler($name)
    {
        return new \LocalCoast\LocalBot\EventHandler($this, $name);
    }

    protected function pm($message, $to = '')
    {
        if ('' == $to) {
            $to = $this->getEvent()->getChannel();
        }

        $msg = new \LocalCoast\LocalBot\Command\Privmsg($to, $message);

        $this->getResponse()->add($msg);
    }

    /**
     * Registeres a new event handler
     *
     * @param   \LocalCoast\LocalBot\EventHandler   $eventHandler
     *
     * @return  \LocalCoast\LocalBot\Plugin
     */
    protected function registerEventHandler(
        \LocalCoast\LocalBot\EventHandler $eventHandler
    ) {
        \Zend\Registry::get('lb_EventHandlerContainer')->add(
            get_class($this) . $eventHandler->getEventName(),
            $eventHandler
        );

        return $this;
    }

    /**
     * Unregisteres a event handler
     *
     * @param   string  $name
     *
     * @return  \LocalCoast\LocalBot\Plugin
     */
    protected function deregisterEventHandler($name)
    {
        \Zend\Registry::get('lb_EventHandlerContainer')->remove(
            get_class($this) . $name
        );

        return $this;
    }

    /**
     * Returns the event response wrapper
     *
     * @return  \LocalCoast\LocalBot\Event\Response
     */
    public function getResponse()
    {
        if (null == $this->_response) {
            $this->_response = new Response();
        }

        return $this->_response;
    }

}
