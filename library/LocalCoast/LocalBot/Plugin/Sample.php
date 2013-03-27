<?php
namespace LocalCoast\LocalBot\Plugin;

use LocalCoast\LocalBot\Plugin as LocalBotPlugin;
use LocalCoast\LocalBot\EventHandler\Condition;
use LocalCoast\Reloadable as Reloadable;

class Sample extends LocalBotPlugin implements Reloadable
{

    const MODULE_NAME = 'sample';

    public function handleEvent($eventName)
    {
        switch ($eventName) {
            case 'test':
                echo 'blah!';
//                $cmd = new \LocalCoast\LocalBot\Command\Notice('AndrewX192', 'Hello World!');
//                $cmd = new \LocalCoast\LocalBot\Command\Nick('LocalBot3');
                $cmd = new \LocalCoast\LocalBot\Command\Oper('Andrew', 'test');

                echo $cmd;
//               $cmd = new \LocalCoast\LocalBot\Command\Kick(
//                       '#test','LocalBot', 'bye');
               $cmd = new \LocalCoast\LocalBot\Command\Away();

               echo PHP_EOL . $cmd .PHP_EOL;
                $this->getResponse()->add($cmd);
               // $cmd = new \LocalCoast\LocalBot\Command\Nick('LocalBot3');

//                $this->getResponse()->add($cmd);

                break;
            default:
                break;
        }
    }

    public function messageEvent()
    {

    }

    public function _deregisterEventHandlers()
    {
        $this->deregisterEventHandler('test');
    }

    public function _registerEventHandlers()
    {
        $eventHandler = $this->getNewEventHandler('test');

        $condition = new \LocalCoast\LocalBot\EventHandler\Condition\Nick(array('andrew', 'AndrewX192'), false);

        $eventHandler->addCondition($condition);

        $this->registerEventHandler($eventHandler);

        return $this;
    }

    public function deregister()
    {

    }

    public function load()
    {

        return $this;
    }

    public function onDeregister()
    {

    }

    public function onLoad()
    {
    }


}