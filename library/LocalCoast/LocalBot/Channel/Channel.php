<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast\LocalBot\Channel;

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

    /**
     * A collection of members
     *
     * @var array
     */
    protected $_members;

    /**
     * The default constructor
     *
     * @param   string  $name
     */
    public function __construct($name)
    {
        $this->_name    = $name;
        $this->_members = array();
    }

    /**
     * Sets the name of the channel
     *
     * @param   string  $name
     *
     * @return  \LocalCoast\LocalBot\Channel\Channel
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
     * @return  \LocalCoast\LocalBot\Channel\Channel
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
     * @return  \LocalCoast\LocalBot\Channel\Channel
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

    /**
     * Adds a member to the channel
     *
     * @param   \LocalCoast\LocalBot\User   $member
     *
     * @return  \LocalCoast\LocalBot\Channel\Channel
     */
    public function addMemmber($member)
    {
        $this->_members[$member->getNick()] = $member;

        return $this;
    }

    /**
     * Adds an array of members
     *
     * @param   array   $members
     *
     * @return  \LocalCoast\LocalBot\Channel
     */
    public function addMembers($members)
    {
        foreach ($members as $member) {
            $this->addMemmber($member);
        }

        return $this;
    }

    /**
     * Returns the number of users in the channel
     *
     * @return  int
     */
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
     * @param   string|\LocalCoast\LocalBot\User    $member
     *
     * @return  boolean
     */
    public function containsMember($member)
    {
        if (!is_string($member)) {
            $member = $member->getNick();
        }

        return array_key_exists($member, $this->_members);
    }

    /**
     * Adds members into the channel from the /NAMES format
     *
     * @param   string  $namesReply
     *
     * @return  \LocalCoast\LocalBot\Channel\Channel
     */
    public function addMembersFromNamesReply($namesReply)
    {
        $users = explode(' ', $namesReply);

        foreach ($users as $user) {
        }

        return $this;
    }

    protected function getAccessFromPrefixString($prefix)
    {
        $prefixes = array(
            '~' =>  array(
                'mode'  => 'q',
            ),
            '&' =>  array(
                'mode'  => 'a',
            ),
            '@' =>  array(
                'mode'  => 'o',
            ),
            '%' =>  array(
                'mode'  => 'h',
            ),
            '+' =>  array(
                'mode'  => 'v',
            ),
        );

        for ($i = 0; $i < strlen($prefix); $i++) {

        }
    }

}