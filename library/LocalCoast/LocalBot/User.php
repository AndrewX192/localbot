<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot;

/**
 * LocalCoast LocalBot User
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
class User
{
    /**
     * Contains a user's GECOS name
     *
     * @var string
     */
    protected $_name;

    /**
     * @var string
     *
     * Contains a user's nickname
     */
    protected $_nickname;

    /**
     * The hostname of the user
     *
     * @var string
     */
    protected $_hostname;

    /**
     * The ident of the user
     *
     * @var string
     */
    protected $_ident;

    /**
     * Sets a user's GECOS name
     *
     * @param   string  $name
     *
     * @return  \LocalCoast\LocalBot\User
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Returns a user's GECOS name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the hostname of the user
     *
     * @param   string  $hostname
     *
     * @return  \LocalCoast\LocalBot\User
     */
    public function setHostname($hostname)
    {
        $this->_hostname = $hostname;

        return $this;
    }

    /**
     * Returns the hostname of the user
     *
     * @return  string
     */
    public function getHostname()
    {
        return $this->_hostname;
    }

    /**
     * Sets the identof the user
     *
     * @param   string  $ident
     *
     * @return  \LocalCoast\LocalBot\User
     */
    public function setIdent($ident)
    {
        $this->_ident = $ident;

        return $this;
    }

    /**
     * Returns the ident of the user
     *
     * @return  string
     */
    public function getIdent()
    {
        return $this->_ident;
    }

}