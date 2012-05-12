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
 * @category   Tulipa
 * @package    Tulipa_Plugins
 * @subpackage Navigation
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: AuthCheck.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Check user identity.
 * 
 * Only identitfied users can access Tulipa.
 * 
 * @category   Tulipa
 * @package    Tulipa_Plugins
 * @subpackage Navigation
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Plugin_AuthCheck extends Zend_Controller_Plugin_Abstract
{    
    /**
     * Front controller dispatch.
     * 
     * Check if user has identity. If not, redirect to login page.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        /**
         * Only for the Tulipa module.
         */
        if ($request->getModuleName() === 'tulipa') {
                     
            $identity = Zend_Auth::getInstance()->hasIdentity();
            
            if (!$identity) {
            	
                /** Change the layout. **/
                $layoutHelper = Zend_Controller_Action_HelperBroker::getExistingHelper('layout');
                $layoutHelper->setLayout('login');
                /** Redirect to login page. **/
                $request->setControllerName('login');
                $request->setActionName('index');
                
                Zend_Controller_Front::getInstance()->getRequest()
                                                    ->setParam('controller', 'login')
                                                    ->setParam('action', 'index');
            }
        }
    }
}