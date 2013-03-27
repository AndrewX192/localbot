<?php

namespace LocalCoast\LocalBot;

use \LocalCoast\LocalBot\Container as ContainerAbstract;

class PluginContainer extends ContainerAbstract
{

    private $_isMutated;

    public function __construct()
    {
        parent::__construct();

        $this->_isMutated = true;
    }

    public function add($key, $value)
    {
        parent::add($key, $value);

        $this->_isMutated = true;
    }

    public function remove($key)
    {
        parent::remove($key);

        $this->_isMutated = true;
    }

    public function isMutated()
    {
        return $this->_isMutated;
    }

    public function setFromArray($array)
    {
        parent::setFromArray($array);

        $this->_isMutated = true;
    }

    public function toArray()
    {
        $this->_isMutated = false;

        return parent::toArray();
    }
}