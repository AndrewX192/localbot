<?php

namespace LocalCoast\LocalBot\Event;

class Response
{
    protected $_priority = 0;

    protected $_sendQueue;

    public function __constructor()
    {
        $this->_sendQueue = array();
    }

    public function add($command) {
        $this->_addMessage($command);

        return;
    }

    private function _addMessage($message)
    {
        if (!empty($message)) {
            $this->_sendQueue[] = $message;
        }

        return $this;
    }

    public function getMessages()
    {
        return $this->_sendQueue;
    }

    public function getNextMessage()
    {
        return array_shift($this->_sendQueue);
    }

    public function clear()
    {
        $this->_sendQueue = array();
    }
}