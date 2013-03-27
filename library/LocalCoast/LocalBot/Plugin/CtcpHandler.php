<?php
namespace LocalCoast\LocalBot\Plugin;

use LocalCoast\LocalBot\Plugin as LocalBotPlugin;
use LocalCoast\LocalBot\EventHandler\Condition;

class CtcpHandler extends LocalBotPlugin
{
    const MODULE_NAME = 'ctcp_handler';

    public function handleEvent($eventName)
    {
        switch ($eventName) {
            case 'ping':
//                $this->getResponse()->add(
//                    new \LocalCoast\LocalBot\Command\Pong(
//                        $this->getEvent()->getSource()
//                    )
//                );
                break;

            case 'version':
                $this->getResponse()->add(
                    new \LocalCoast\LocalBot\Command\Notice(
                        $this->getEvent()->getNick(),
                        chr(001) . 'VERSION LocalBot 3' .chr(001)
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
    }

    public function _registerEventHandlers()
    {
        // CTCP PING
        $eventHandler = $this->getNewEventHandler('ping');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Regex(
            "/" . chr(001) . 'PING (.*)' . chr(001) . "/"
        );

        $eventHandler->addCondition($condition);

        $this->registerEventHandler($eventHandler);

        // CTCP VERSION
        $eventHandler = $this->getNewEventHandler('version');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Regex(
            "/" . chr(001) . 'VERSION' . chr(001) . "/"
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
