<?php

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

defined('ROOT_PATH')
|| define('ROOT_PATH',realpath(dirname(__FILE__) ));

defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

defined('PUBLIC_PATH')
|| define('PUBLIC_PATH', APPLICATION_PATH . '/public');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH . '/vendor/zendframework/zendframework1/library'),
    realpath(ROOT_PATH . '/vendor/Business'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';


// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
    ->run();
