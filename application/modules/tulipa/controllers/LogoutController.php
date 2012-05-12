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
 * @package    Tulipa_Controllers
 * @subpackage Logout
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: LogoutController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Logout controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Logout
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_LogoutController extends Tulipa_Controller_Action
{
    /**
     * Logout from the system.
     * 
     * @return void
     */
    public function indexAction()
    {
    	
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
            
            $ckFinderSession = new Zend_Session_Namespace('CKFinder');
            
            /** Disable CKFinder **/
            $ckFinderSession->allowed = false;
        }
        
        /**
         * Redirect to the index page.
         */
        $this->_helper->redirector->gotoRouteAndExit(array(
            'controller' => 'index',
            'action' =>'index'), 'tulipa', true);
    }
}