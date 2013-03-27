<?php

namespace LocalCoast\LocalBot\Connection;

class Socket2 extends \LocalCoast\LocalBot\Connection
{

    public function connect($options)
    {
        parent::__construct($options);

        if (false === ($resource = @fsockopen($this->getOption('hostname'), $this->getOption('port')))) {
//            die;
        }

        socket_set_blocking($resource, false);

        $this->setResource($resource);

        return $resource;
    }

    /**
     * Closes the connection
     *
     * @return  \LocalCoast\LocalBot\Connection
     */
    public function close()
    {
        if (false === fclose($this->getResource())) {
            throw new \LocalCoast\LocalBot\Exception(
                'cannot close connection'
            );
        }
    }

    /**
     * Reads data from the connection
     */
    public function read()
    {
        return trim(fgets($this->getResource(), 4096));
    }

    public function write($buffer)
    {
        fputs($this->getResource(), $buffer);

        return $this;
    }

    public function writeln($buffer)
    {
        $this->write($buffer . PHP_EOL);
    }
}
