<?php
namespace LocalCoast\LocalBot\Plugin;

use LocalCoast\LocalBot\Plugin as LocalBotPlugin;
use LocalCoast\LocalBot\EventHandler\Condition;

class ActivityTracker extends LocalBotPlugin
{
    const MODULE_NAME = 'ctcp_handler';

    public function handleEvent($eventName)
    {
        switch ($eventName) {
            case 'onjoin':
                $network = $this->getEvent()->getNetwork();

                if (!$network->hasChannel(
                    $this->getEvent()->getChannel()
                )) {

                    $channel = new \LocalCoast\LocalBot\Channel\Channel(
                        $this->getEvent()->getChannel()
                    );

                    $network->addChannel($channel);
                }

                break;

            case 'on_names_reply':
                $network = $this->getEvent()->getNetwork();

                if ($network->hasChannel(
                    $this->getEvent()->getChannel()
                )) {
                    $channel = $network->getChannel(
                        $this->getEvent()->getChannel()
                    );

                    $channel->addMembersFromNamesReply($this->getEvent()->getMessage());

                }
                break;
            default:
                break;
        }
    }

    public function _deregisterEventHandlers()
    {
        $this->deregisterEventHandler('on_join');
    }

    public function _registerEventHandlers()
    {
        // ON JOIN
        $eventHandler = $this->getNewEventHandler('onjoin');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Command(
            "JOIN"
        );

        $eventHandler->addCondition($condition);

        $this->registerEventHandler($eventHandler);

        // 353 NAMES Handler
        $eventHandler = $this->getNewEventHandler('on_names_reply');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Command(
            353
        );

        $eventHandler->addCondition($condition);

        $this->registerEventHandler($eventHandler);

        // ON PART
        $eventHandler = $this->getNewEventHandler('onpart');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Command(
            "PART"
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
