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

$client = new Kokx_Irc_Client(array(
    'address'  => 'irc.freenode.net',
    'nickname' => 'Firal_Bot',
    'username' => 'Firal_Bot',
    'realname' => 'Firal Bot',
    'version'  => 'Firal IRC bot v0.1'
));

$bot = new Kokx_Irc_Bot($client, array(
    'plugins' => array(
        new Kokx_Irc_Bot_Plugin_GitHub(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'github-json')
    )
));

$client->sendRaw('JOIN #firal');

// connect and start listening
$client->connect();
