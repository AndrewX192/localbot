<?php

namespace LocalCoast;

class Socket
{

    /**
     * The php socket resource
     *
     * @var resource
     */
    protected $_socket;

    /**
     * An array of valid domains
     *
     * @var array
     */
    private $_validDomains = array(
        AF_INET,
        AF_INET6,
        AF_UNIX,
    );

    /**
     * An array of valid communication types
     *
     * @var array
     */
    private $_validTypes = array(
        SOCK_STREAM,
        SOCK_DGRAM,
        SOCK_SEQPACKET,
        SOCK_RAW,
        SOCK_RDM,
    );

    /**
     * An array of valid protocols
     *
     * @var array
     */
    private $_validProtocols = array(
        'icmp',
        'udp',
        'tcp',
    );

    protected $_domain = AF_INET;

    protected $_type;

    protected $_protocol;

    public function __construct($options = array())
    {
        $this->_checkCompatibility();
    }

    /**
     * Creates a socket.
     *
     * @return  \LocalCoast\Socket
     */
    protected function _create()
    {

        $this->_socket = socket_create(
            $this->getDomain(),
            $this->getType(),
            $this->getProtocol()
        );

        return $this;
    }

    /**
     * Returns the php socket resource
     *
     * @return  resource
     */
    public function getResource()
    {
        return $this->_socket;
    }

    /**
     * Returns the domain
     *
     * @return  int
     */
    public function getDomain() {
        return $this->_domain;
    }

    /**
     * Sets the domain to use when creating the socket
     *
     * @param   int $domain
     *
     * @throws  \LocalCoast\Socket\Exception
     *
     * @return  \LocalCoast\Socket
     */
    public function setDomain($domain)
    {
        if (!array_key_exists($domain, $this->_validDomains)) {
            throw new \LocalCoast\Socket\Exception(
                'the specified domain is not valid, please see php.net/socket_create '
                    . 'for a list of valid domains'
            );
        }

        $this->_domain = $domain;

        return $this;
    }

    /**
     * Returns the type of communication to be used by the socket.
     *
     * @return  int
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Sets the type of communication to be used by the socket
     *
     * @return  \LocalCoast\Socket
     */
    public function setType($type)
    {
        if (!in_array($type, $this->_validTypes)) {
            throw new \LocalCoast\Socket\Exception(
                'the specified domain is not valid, please see php.net/socket_create '
                    . 'for a list of valid domains'
            );
        }

        $this->_type = $type;

        return $this;
    }

    /**
     * Returns the proptocol
     *
     * @return  int
     */
    public function getProtocol()
    {
        return $this->_protocol;
    }

    /**
     * Sets the type of communication to be used by the socket
     *
     * @return  \LocalCoast\Socket
     */
    public function setProtocol($protocol)
    {
        if ($protocol == filter_var($protocol, FILTER_VALIDATE_INT)) {
            $protocol = getprotobynumber($protocol);
        }

        if (!in_array($protocol, $this->_validProtocols)) {
            throw new \LocalCoast\Socket\Exception(
                'the specified protocol is not valid, please see php.net/socket_create '
                    . 'for a list of valid protocols'
            );
        }

        $this->_protocol = getprotobyname($protocol);

        return $this;
    }


    public function write($buffer)
    {
        return $this->_write($buffer);
    }

    protected function _write($buffer, $length = null)
    {
        if ($length) {
            $isSuccessful = socket_write($this->getResource(), $buffer, $length);
        } else {
            $isSuccessful = socket_write($this->getResource(), $buffer);
        }

        if (false === $isSuccessful) {
            throw new \LocalCoast\Socket\Exception(
                'the write operation returned an error: "'
                    . socket_strerror(socket_last_error($this->getResource())) . '"',
                socket_last_error($this->getResource())
            );
        }

        return $isSuccessful;
    }

    public function read($length = null, $type = PHP_BINARY_READ)
    {
        try {
            $isSuccesful = socket_read($this->getResource(), $length, $type);
        } catch (Exception $e) {
            $isSuccesful = false;
        }

        if (false === $isSuccesful) {
            throw new \LocalCoast\Socket\Exception(
                'the read operation returned an error: "'
                    . socket_strerror(socket_last_error($this->getResource())) . '"',
                socket_last_error($this->getResource())
            );
        }

        return $isSuccesful;
    }

    public function recv($length = null, $type = MSG_DONTWAIT)
    {
        $buffer = null;

        if (false === ($bytes = socket_recv($this->getResource(),$buffer, 512,
            MSG_WAITALL
        ))) {
            throw new \LocalCoast\Socket\Exception(
                'the recv operation returned an error: "'
                    . socket_strerror(socket_last_error($this->getResource())) . '"',
                socket_last_error($this->getResource())
            );
        }

        return $buffer;
    }

    public function getBackLog()
    {

    }

    /**
     * Performs compatibility checks to ensure the installation of PHP
     * meets all of the required dependencies.
     *
     * @throws  \LocalCoast\Socket\Exception
     */
    private function _checkCompatibility()
    {
        if (!extension_loaded('sockets')) {
            throw new \LocalCoast\Socket\Exception(
                'Sockets support is not avaiable for this installation of PHP. '
                    . 'please check php.net/sockets for details'
            );
        }

        return $this;
    }
}
