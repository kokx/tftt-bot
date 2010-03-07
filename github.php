<?php
if (empty($_POST['payload'])) {
    exit("I'm sorry honey, but I don't have anything for you!");
}
if (!preg_match('/github\.com$/i', gethostbyaddr($_SERVER['REMOTE_ADDR']))) {
    exit("Damn nubcake!");
}

$config = require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';

// just save the data
file_put_contents($config['github']['savefile'], $_POST['payload']);
