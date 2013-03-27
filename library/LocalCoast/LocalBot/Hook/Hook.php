<?php

class Hook
{
    protected $_conditions = array();

    public function matchesEvent($event)
    {

    }


    public function getConditions()
    {
        return $this->_conditions;
    }

    /**
     * Does the event meet all of the requirements?
     *
     * @param   \LocalCoast\LocalBot\Event $event
     *
     * @return  boolean
     */
    protected function _matchesEvent(\LocalCoast\LocalBot\Event $event)
    {
        foreach ($this->getConditions() as $k => $condition) {

        }

        return true;
    }


}