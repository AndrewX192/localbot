<?php
/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

namespace LocalCoast;

/**
 * LocalCoast LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

use \LocalCoast\LocalBot\Event\Event;

class LocalBot
{

    /**
     * The startup time of LocalBot
     *
     * @var int
     */
    private $_startupTime;

    /**
     * A container of event handlers
     *
     * @var type
     */
    private $_eventHandlers;

    /**
     * A container of networks
     *
     * @var \LocalCoast\LocalBot\Network\Container
     */
    protected $_networks;

    /**
     * A message queue
     *
     * @var \LocalCoast\LocalBot\MessageQueue
     */
    protected $_messageQueue;

    /**
     * An array of chat connections
     *
     * @var array
     */
    protected $_connections = array();

    public function __construct($config = array())
    {
        $this->_compatibilityCheck();

        $this->_preInit()
             ->init()
             ->setOptions($config)
             ->_postInit();
    }

    /**
     * Handles pre-initalization
     *
     * @return  \LocalCoast\LocalBot
     */
    protected function _preInit()
    {
        return $this;
    }

    /**
     * Handles initalization
     *
     * @return  \LocalCoast\LocalBot
     */
    protected function init()
    {
        $this->_startupTime = time();

        if (extension_loaded('pcntl')) {
            $handledSignals = array(
                SIGTERM,
                SIGINT,
                SIGUSR1,
                SIGUSR2,
                SIGHUP,
            );

            declare (ticks = 1);

            foreach ($handledSignals as $handledSignal) {
                pcntl_signal($handledSignal, array($this, 'handleSignal'));
            }
        }

        /**
         * @see \LocalCoast\Exception
         */
        require_once 'LocalCoast/Exception.php';
        set_error_handler(array('\LocalCoast\Exception', 'throwError'));

        \Zend\Registry::getInstance();

        $this->_networks        = new \LocalCoast\LocalBot\Network\Container();
        $this->_messageQueue    = new \LocalCoast\LocalBot\MessageQueue();

        $eventHandlerContainer  = new \LocalCoast\LocalBot\EventHandler\Container();
        $pluginContainer        = new \LocalCoast\LocalBot\PluginContainer();

        $this->_eventHandlers   = $eventHandlerContainer->toArray();
        $this->_plugins         = $pluginContainer->toArray();

        \Zend\Registry::set('lb_EventHandlerContainer', $eventHandlerContainer);
        \Zend\Registry::set('lb_PluginContainer', $pluginContainer);

        return $this;
    }

    /**
     * Handles post-initalization
     *
     * @return  \LocalCoast\LocalBot
     */
    protected function _postInit()
    {
        return $this;
    }

    /**
     * Loads a configuration file
     *
     * @param   string  $file
     * @param   string  $directive
     */
    public function loadConfigFile($file, $directive = 'config')
    {
        $config = new \Zend\Config\Xml($file, $directive);

        foreach ($config->networks as $net) {
            $network = new \LocalCoast\LocalBot\Network\Network(
                $net->name
            );

            $network->setFromArray($net->toArray());

            foreach ($net->servers as $serv) {
                $server = new \LocalCoast\LocalBot\Network\Server();
                $server->setFromArray($serv->toArray());

                $network->addServer($server);
            }

            $this->_networks->add($network->getName(), $network);
        }
    }

    /**
     * Sets options for LocalBot
     *
     * @param   \Zend\Config|array  $config
     */
    public function setOptions($config)
    {
        if (is_array($config)) {
            $config = new \Zend\Config\Config($config);
        }

        \Zend\Registry::set('lb_config', $config);

        return $this;
    }

    /**
     * Connects to a new server
     *
     * @param   \LocalCoast\LocalBot\Network\Network    $network
     * @param   \LocalCoast\LocalBot\Network\Server     $server
     *
     * @return  \LocalCoast\LocalBot
     */
    public function connectTo($network, $server = null)
    {
        if (null === $server) {
            $server = $network->getServer(0);
        }

        $this->_connect($server);

        $connection = end($this->_connections);

        $connection->setNetwork($network);

        $connection->writeln('USER localbot 0 * :LocalCoast LocalBot');
        $connection->writeln(new \LocalCoast\LocalBot\Command\Nick($network->getNick()));

        return $this;
    }

    /**
     * Establishes a connection to the server
     *
     * @param   string  $server
     * @param   string  $port
     *
     * @throws  \Exception
     */
    protected function _connect($server)
    {
        $connection = new \LocalCoast\LocalBot\Connection\Socket2();

        $connection->setOptions(
            $server->toArray()
        );

        try {
            $connection->connect($server->getHostname(), $server->getPort());
        } catch (\LocalCoast\LocalBot\Exception $e) {
            throw $e;
        }

        $this->_connections[] = $connection;

    }

    public function getConnections()
    {
        return $this->_connections;
    }

    /**
     * Removes a connection
     *
     * @param type $connection
     */
    public function removeConnection($connection)
    {
        unset ($this->_connections[array_search($connection, $this->_connections)]);
    }

    public function getMessageQueue()
    {
        return $this->_messageQueue;
    }

    /**
     * Returns an array of registered event handlers
     *
     * @return  array
     */
    public function getRegisteredEventHandlers()
    {
        return $this->_eventHandlers;
    }

    /**
     * The lifetime of the bot
     */
    protected function _process()
    {
        $running = true;

        while ($running) {
            usleep(1500);
            pcntl_signal_dispatch();

            foreach ($this->getConnections() as $connection) {
                // Lost connection
                if (feof($connection->getResource())) {
                    $this->removeConnection($connection);

                    continue;
                }

                $eventString  = $connection->read();

                if (0 === strlen($eventString)) {
                    continue;
                }

                $this->getLogger()->log($eventString, \Zend\Log\Logger::DEBUG);

                $event = new Event($eventString);

                $event->setNetwork($connection->getNetwork());

                $this->_handleEvent($connection, $event);
            }

            // LocalBot specific handlers
            $eventHandlerContainer = \Zend\Registry::get('lb_EventHandlerContainer');

            if ($eventHandlerContainer->isMutated()) {
                $this->_eventHandlers = $eventHandlerContainer->toArray();
            }

            if (!$this->getMessageQueue()->isEmpty()) {
                $this->getMessageQueue()->pushMessage();
            }
        }
    }
    /**
     * Handles an event
     *
     * @param   $connection
     * @param   \LocalCoast\LocalBot\Event\Event    $event
     */
    protected function _handleEvent($connection, $event)
    {
        foreach ($this->getRegisteredEventHandlers() as $eventHandler) {
            if ($eventHandler->matchesEvent($event)) {
                $response = $eventHandler->run($event);

                if (null !== $response->getMessages()) {
                    foreach ($response->getMessages() as $message) {
                        $this->getLogger()->log($message, \Zend\Log\Logger::DEBUG);

                        $connection->writeln($message);
                    }

                    $response->clear();
                }
            }
        }
    }

    /**
     * Runs the bot
     *
     * @return  boolean
     */
    public function run()
    {
        try {
            foreach ($this->_networks as $network) {
                $this->connectTo($network);
            }

            $this->_process();

            return true;
        } catch (Exception $e) {
            $this->getLogger()->log(
                get_class($this) . ' had an error: ' . PHP_EOL . $e->getTraceAsString(),
                \Zend\Log\Logger::EMERG
            );

            return false;
        }
    }

    public function loadPlugin($filePath)
    {
        $pluginName = '';

        if (!file_exists($filePath)) {
            return false;
        }

        $file = \Zend\Code\Generator\FileGenerator::fromReflectedFileName($filePath);

        $classes    = $file->getClasses();
        $class      = current($classes);
        $pluginName = $class->getName();

        $class = new \Zend\Code\Reflection\ClassReflection(
                $class->getNamespaceName() . '\\' . $class->getName()
        );

        $generatedClass = \LocalCoast\Code\Generator\ClassGenerator::fromReflection($class);

        $fileGenerator = new \Zend\Code\Generator\FileGenerator();

        require_once 'LocalCoast/LocalBot/Plugin.php';
        $generatedClass->setExtendedClass('LocalBotPlugin');

        $fileGenerator->setNamespace($generatedClass->getNamespaceName());
        $generatedClass->setNamespaceName(null);

        $fileGenerator->setUses($file->getUses())
                      ->setClass($generatedClass);

//        echo $generatedClass->generate();die;

//        var_dump($fileGenerator->getUses());die;
//        var_dump($generatedClass->getName());die;
//
//        $fileGenerator = new \Zend\Code\Generator\FileGenerator();
//
//        $fileGenerator->setClass($generatedClass);
//
//        var_dump($fileGenerator->generate());die;
//
//        $classCount = 1;
//        foreach ($file->getClasses() as $class) {
//            if ($classCount != 1) {
//                return false;
//            }
//
//            $name = $class->getShortName();
//        }
//
//        var_dump($class);die;
//
//        $file->setName($this->_generateClassName($file->getName()));
//
//        var_dump($file->getClasses());die;
//
//        $plugin = file_get_contents($filePath);
//
//        $reflection = new \Zend\Code\Scanner\FileScanner($filePath);
//
//        $classCount = 1;
//
//        foreach ($reflection->getClasses() as $class) {
//            if ($classCount != 1) {ch
//
//                return false;
//            }
//
//            $name = $class->getShortName();
//        }
//        die;

        $tmpName = $this->_generateClassName($generatedClass->getName());

        while (class_exists($tmpName)) {
            $tmpName = $this->_generateClassName($name);
        }

        $generatedClass->setName($tmpName);

        if (in_array('Reloadable', $generatedClass->getImplementedInterfaces())) {

        }

        // Create, generate, write, close, and delete.
        $file = tempnam(null, 'plugin-');
        $fp = fopen($file, 'w');
        fwrite ($fp, $fileGenerator->generate());
        fclose($fp);

        if (null !== ($isOkay = shell_exec('php -l ' . escapeshellarg($file) . ' 2> /dev/null'))) {
            if (!preg_match('/No syntax errors detected in (.*)/', $isOkay)) {
                unlink($file);
                return;
            }
        }

        require_once $file;

        unlink($file);

        $namespace = $fileGenerator->getNamespace();

        $qualifiedName = $namespace . '\\' . $tmpName;

        $plugin = new $qualifiedName();

        try {
            $plugin->load()
                   ->_registerEventHandlers()
                   ->load();

             \Zend\Registry::get('lb_PluginContainer')->add($pluginName, $plugin);
        } catch (Exception $e) {
            $this->getLogger()->log($e->getMessage() . \Zend\Log\Logger::CRIT);

            $plugin->_unregisterEventHandlers()
                 ->__destory();
        }

    }

    public function unloadPlugin($name)
    {
        $pluginContainer = \Zend\Registry::get('lb_PluginContainer');

        if (!$pluginContainer->containsKey($name)) {
            return false;
        }

        $plugin = $pluginContainer->get($name);

        if (!$plugin instanceof \LocalCoast\Reloadable) {
            return false;
        }

        $plugin->_deregisterEventHandlers()
                ->deregister();

        $pluginContainer->remove($name);

        $plugin = null;

        gc_collect_cycles();

        return true;

    }

    /**
     * Attempts to generate a unique class name.
     *
     * @param   string  $name
     *
     * @return  string
     */
    private function _generateClassName($name)
    {
        return $name . substr(uniqid(), -5);
    }

    /**
     * Returns the main instance of \Zend\Log\Logger
     *
     * @return  \Zend\Log\Logger
     */
    public function getLogger()
    {
        return \Zend\Registry::get('logger');
    }

    /**
     * Sets the logger
     *
     * @param   \Zend\Log\Logger    $logger
     *
     * @return  \LocalCoast\LocalBot
     */
    public function setLogger($logger)
    {
        \Zend\Registry::set('logger', $logger);

        return $this;
    }


    /**
     * Handles PCNTL signals
     *
     * @param   int $signal
     */
    public static function handleSignal($signal)
    {
        switch ($signal) {
            case SIGTERM:
                break;
            case SIGINT:
                // remove the console's ^C
                print chr(8) . chr(8);
                exit;
                break;
            case SIGUSR1:
                break;
            case SIGUSR2:
                break;
            case SIGHUP:
                break;
            default:
                \Zend\Registry::get('logger')->log(
                    'Uncaught signal handler for ' . $signal
                );
        }
    }

    /**
     * Performs compatibility checks to ensure the installation of PHP
     * meets all of the required dependencies.
     *
     * @throws  \LocalCoast\LocalBot\Exception
     */
    private function _compatibilityCheck()
    {
        if (function_exists('posix_getuid')) {
            if (0 == posix_getuid()) {
                throw new \LocalCoast\LocalBot\Exception(
                    'LocalBot cannot be run as root.'
                );
            }
        }

        return $this;
    }

    /**
     * The class destructor
     */
    public function __destruct()
    {
        foreach (\Zend\Registry::get('lb_PluginContainer') as $plugin) {
            $plugin = null;
        }

        foreach (\Zend\Registry::get('lb_EventHandlerContainer') as $eventHandler) {
            $eventHandler = null;
        }
    }

}
