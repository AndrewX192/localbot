<?php

namespace LocalCoast\LocalBot\Connection;

class Socket extends \LocalCoast\LocalBot\Connection
{

    public function connect($options)
    {
        parent::__construct($options);

        $sock = new \LocalCoast\Socket\Client();

        $sock->setType(SOCK_STREAM);

        $sock->connect(
            $this->getOption('hostname'),
            $this->getOption('port')
        );

        $this->setResource($sock);

        return $sock;
    }

    public function close() {

    }

    public function read()
    {
        return trim($this->getResource()->read(512, PHP_NORMAL_READ));
    }

    public function write($buffer)
    {
        $this->getResource()
             ->write($buffer);

        return $this;
    }

    public function writeln($buffer)
    {
        $this->write($buffer . PHP_EOL);
    }
}
