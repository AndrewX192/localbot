<?php

namespace LocalCoast\LocalBot;


abstract class Command
{
    protected $_target;

    protected $_targets;

    protected $_message;

    protected $_argument;

    /**
     * Returns the command to be sent to the server
     *
     * @return  string
     */
    public function getCommand()
    {
        $class = explode('\\', get_class($this));

        return strtoupper(end($class));
    }

    /**
     * Returns whether or not the command has a target
     *
     * @return  boolean
     */
    public function hasTarget()
    {
        return (0 != strlen($this->_target));
    }

    /**
     * Returns the target of this command
     *
     * @return  string
     */
    public function getTarget()
    {
        return $this->_target;
    }

    /**
     * Returns whether or not the command has a target list
     *
     * @return  boolean
     */
    public function hasTargets()
    {
        return ((boolean) count($this->_targets));
    }


    public function getTargets()
    {
        return $this->_targets;
    }

    protected function setTarget($target)
    {
        $this->_target = $target;

        return $this;
    }

    public function hasMessage()
    {
        return (0 != strlen($this->_message));
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function setMessage($message)
    {
        $this->_message = $message;

        return $this;
    }

    public function setArgument($argument)
    {
        $this->_argument = $argument;

        return $this;
    }

    public function getArgument()
    {
        return $this->_argument;
    }

    public function hasArgument()
    {
        return (0 != strlen($this->_argument));
    }

    /**
     * Creates a string representing the command to send to the server.
     *
     * @return string
     */
    public function __toString()
    {
        $ret = $this->getCommand() . ' ';

        if ($this->hasTarget()) {
            $ret .= $this->getTarget() . ' ';
        } else if ($this->hasArgument()) {
            $ret .= ':' . $this->getArgument();
        }

        if ($this->hasMessage()) {
            $ret .= ':' . $this->getMessage();
        }

        if ($this->hasTargets()) {
            $ret .= $this->getTargets() . ' ';
        }

        return $ret;
    }
}