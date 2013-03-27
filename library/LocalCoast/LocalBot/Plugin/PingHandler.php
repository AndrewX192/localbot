<?php
namespace LocalCoast\LocalBot\Plugin;

use LocalCoast\LocalBot\Plugin as LocalBotPlugin;
use LocalCoast\LocalBot\EventHandler\Condition;

class PingHandler extends LocalBotPlugin
{
    const MODULE_NAME = 'ping_handler';

    public function handleEvent($eventName)
    {
        switch ($eventName) {
            case 'ping':
                $this->getResponse()->add(
                    new \LocalCoast\LocalBot\Command\Pong(
                        $this->getEvent()->getSource()
                    )
                );
                break;
            default:
                break;
        }
    }

    public function _deregisterEventHandlers()
    {
        $this->deregisterEventHandler('ping');

        return $this;
    }

    public function _registerEventHandlers()
    {
        $eventHandler = $this->getNewEventHandler('ping');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Command(
            'PING'
        );

        $eventHandler->addCondition($condition);

        $this->registerEventHandler($eventHandler);


        return $this;
    }

    public function deregister()
    {
        return $this;
    }

    public function load()
    {
        return $this;
    }

    public function onDeregister() {}

    public function onLoad() {}
}
