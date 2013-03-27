<?php
/**
 * LocalCoast Networks LocalBot
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

// Set the include path, excluding the system include path.
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/library'),
)));

require_once 'Zend/Loader/StandardAutoloader.php';

$autoloader = new \Zend\Loader\StandardAutoloader();
$autoloader->registerNamespace('LocalCoast', APPLICATION_PATH . '/library/LocalCoast')
            ->register();

$localbot = new \LocalCoast\LocalBot();

/* Logging */
$logger = new \Zend\Log\Logger();
$logger->addWriter(new \Zend\Log\Writer\Stream('php://output'));

$localbot->setLogger($logger);

/* Load Configuration */
$localbot->loadConfigFile('config.xml');

$localbot->loadPlugin(dirname(__FILE__) . '/library/LocalCoast/LocalBot/Plugin/ActivityTracker.php');
$localbot->loadPlugin(dirname(__FILE__) . '/library/LocalCoast/LocalBot/Plugin/PingHandler.php');
$localbot->loadPlugin(dirname(__FILE__) . '/library/LocalCoast/LocalBot/Plugin/CtcpHandler.php');

//var_dump($localbot->unloadPlugin('PingHandler'));

// run the bot
$localbot->run();
