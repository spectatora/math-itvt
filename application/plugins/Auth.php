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
 * @package    Application_Plugins
 * @subpackage Error Handler
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Auth.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * User identity configuration.
 * 
 * @category   Application
 * @package    Application_Plugins
 * @subpackage Error Handler
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_Controller_Plugin_Abstract
 */
class Application_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    
	/**
	 * Front controller dispatch.
	 * 
	 * Check user status (is identity avaliable). If user has identity
     * send user settings to the view.
	 * 
	 * @param Zend_Controller_Request_Abstract $request
	 * @return void
	 */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        /** No auth needed in command line mode **/
        if (defined('CLI_MODE')) {
            return;
        }
        
		$view = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view;
        
        $auth = Zend_Auth::getInstance();
        
        
        $sessionNamespace = ucfirst($request->getModuleName()) . '_Auth';        
        
        $auth->setStorage(new Zend_Auth_Storage_Session($sessionNamespace));
        
        /**
         * Is user loged in?
         */
        $hasIdentity = $auth->hasIdentity();
        
        /** Send information to the Zend_View. **/
        $view->hasIdentity = $hasIdentity;
        if ($hasIdentity) {
            $view->identity = $auth->getIdentity();
        }
        
    }
    
}