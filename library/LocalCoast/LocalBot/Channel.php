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
 * LocalCoast LocalBot Channel
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
class Channel
{
    /**
     * The channel name
     */
    protected $_name;

    /**
     * The channel modes
     */
    protected $_modes = array();

    /**
     * The timestamp associated with the channels mode
     *
     * @var string
     */
    protected $_modeTS;

    /**
     * The channel topic
     *
     * @var string
     */
    protected $_topic;

    /**
     * The timestamp associated with the channel topic
     *
     * @var int
     */
    protected $_topicTS;

    /**
     * The timestamp associated with the channel
     *
     * @var int
     */
    protected $_ts;

    protected $_members = array();


    /**
     * Sets the name of the channel
     *
     * @param   string  $name
     * @return  \LocalCoast\LocalBot\Channel
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Returns the name of the channel
     *
     * @return  string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the channel's topic
     *
     * @param   string  $topic
     *
     * @return  \LocalCoast\LocalBot\Channel
     */
    public function setTopic($topic)
    {
        $this->_topic = $topic;

        return $this;
    }

    /**
     * Returns the channel's topic
     *
     * @return  string
     */
    public function getTopic()
    {
        return $this->_topic;
    }

    /**
     * Sets the topic timestamp
     *
     * @param   int $timestamp
     *
     * @return  \LocalCoast\LocalBot\Channel Sets tjhe
     */
    public function setTopicTS($timestamp)
    {
        $this->_topicTS = $timestamp;

        return $this;
    }


    /**
     * Returns the timestamp associated with the topic
     *
     * @return  int
     */
    public function getTopicTS()
    {
        return $this->_topicTS;
    }

    public function addMemmber(&$member)
    {
        $this->_members[$member->getNick()] = $member;

        return $this;
    }

    public function addMembers($members)
    {
        foreach ($members as $member) {
            $this->addMemmber($member);
        }

        return $this;
    }

    public function getSize()
    {
        return count($this->members);
    }

    /**
     * Is the channel empty
     *
     * @return  boolean
     */
    public function isEmpty()
    {
        return (0 === $this->getSize());
    }

    /**
     * Returns whether or not the member is on the channe
     *
     * @param   string|\User    $member
     *
     * @return  boolean
     */
    public function containsMember($member)
    {
        if (!is_string($member))
        {
            $member = $member->getNick();
        }

        return array_key_exists($member, $this->_members);
    }

}