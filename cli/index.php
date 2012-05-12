<?php
/**
 * Tulipa © Core 
 * Copyright © 2010 Sasquatch <Joan-Alexander Grigorov>
 *                      http://bgscripts.com
 * 
 * LICENSE
 * 
 * A copy of this license is bundled with this package in the file LICENSE.txt.
 * 
 * Copyright © Tulipa
 * 
 * Platform that uses this site is protected by copyright. 
 * It is provided solely for the use of this site and all its copying, 
 * processing or use of parts thereof is prohibited and pursued by law.
 * 
 * All rights reserved. Contact: office@bgscripts.com
 * 
 * Платформата, която използва този сайт е със запазени авторски права. 
 * Тя е предоставена само за ползване от конкретния сайт и всяко нейно копиране, 
 * преработка или използване на части от нея е забранено и се преследва от закона. 
 * 
 * Всички права запазени. За контакти: office@bgscripts.com
 * 
 * @category   Application
 * @package    Application_Cli
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: index.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/**
 * Get the command line 
 * options using {@see Zend_Console_Getopt}
 */
require_once 'Zend/Console/Getopt.php';

/**
 * @see Zend_Console_Getopt_Exception
 */
require_once 'Zend/Console/Getopt/Exception.php';

try {
    $opts = new Zend_Console_Getopt(
        array(
            'help|h' => 'Displays usage information.',
            'action|A=s' => 'Action to perform in format of module.controller.action',
            'verbose|v' => 'Verbose messages will be dumped to the default output.',
            'development|d' => 'Enables development mode.',
        )
    );
    $opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    exit($e->getMessage() ."\n\n". $e->getUsageMessage());
}

if(isset($opts->h)) {
    echo $opts->getUsageMessage();
    exit;
}

/** Declear that app is working in command line mode **/
define('CLI_MODE', true);

/**
 * Change the request object, 
 * default router and response
 */
if(isset($opts->action)) {
    $reqRoute = array_reverse(explode('.', $opts->action));
    @list($action,$controller,$module) = $reqRoute;

    /**
     * @see Zend_Controller_Request_Simple
     * @see Zend_Controller_Front
     */
    require_once 'Zend/Controller/Request/Simple.php';
    require_once 'Zend/Controller/Front.php';

    $request = new Zend_Controller_Request_Simple($action,$controller,$module);
    $front = Zend_Controller_Front::getInstance();

    $front->setRequest($request);

    /**
     * @see Application_Controller_Router_Cli
     * @see Zend_Controller_Response_Cli
     */
    require_once 'Application/Controller/Router/Cli.php';
    require_once 'Zend/Controller/Response/Cli.php';

    $front->setRouter(new Application_Controller_Router_Cli());
    $front->setResponse(new Zend_Controller_Response_Cli());

    $front->throwExceptions(true);
    $front->addModuleDirectory(APPLICATION_PATH . '/modules/');
}

if (isset($opts->d)) {
    define('APPLICATION_ENV', 'development');
} else {
    // Define application environment
    defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));
}

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
                ->run();