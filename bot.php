<?php

error_reporting(E_ALL | E_STRICT);

define('ROOT_PATH', dirname(__FILE__));
define('LIBRARY_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'library');

$includePath = array(
    LIBRARY_PATH . DIRECTORY_SEPARATOR . 'kokx',
    LIBRARY_PATH . DIRECTORY_SEPARATOR . 'zend',
);
set_include_path(implode($includePath, PATH_SEPARATOR));

require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();

$autoloader->registerNamespace('Kokx');

// configuration
$config = require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'config.php';

// db
$db = new Kokx_Db_Broker($config['bot']['db']['adapter'], $config['bot']['db']['options']);

$client = new Kokx_Irc_Client($config['client']);

// bot
$bot = new Kokx_Irc_Bot($client, array(
    'plugins' => array(
        new Kokx_Irc_Bot_Plugin_NickServ($config['bot']['plugins']['NickServ']),
        new Kokx_Irc_Bot_Plugin_Achievements($db)
    )
));

// starting stuff up
$client->join($config['bot']['channels']);

$client->connect();
