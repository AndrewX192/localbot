<?php

namespace LocalCoast\LocalBot\Plugin;

use LocalCoast\LocalBot\Plugin as LocalBotPlugin;
use LocalCoast\LocalBot\EventHandler\Condition;
use LocalCoast\Reloadable as Reloadable;

class IRC extends LocalBotPlugin implements Reloadable
{

    public function _deregisterEventHandlers()
    {

    }

    public function _registerEventHandlers()
    {
        $eventHandler = new \LocalCoast\LocalBot\EventHandler('irc_connect');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Connection('establish');

        $eventHandler->addCondition($condition);

        $this->registerEventHandler($eventHandler);

        return $this;
    }

    public function deregister() {

    }

    public function load() {

    }

    public function onDeregister() {

    }

    public function onLoad() {

    }

}