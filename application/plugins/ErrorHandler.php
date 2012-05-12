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
 * @version    $Id: ErrorHandler.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Change error handler plugin module.
 * 
 * @category   Application
 * @package    Application_Plugins
 * @subpackage Error Handler
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_Controller_Plugin_Abstract
 */
class Application_Plugin_ErrorHandler extends Zend_Controller_Plugin_Abstract
{
	/**
	 * Front controller dispatch.
	 * 
	 * Change error handler plugin module.
	 * 
	 * @param Zend_Controller_Request_Abstract $request
	 * @return void
	 */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $front = Zend_Controller_Front::getInstance();
        
        /** Set new error handler module. **/
        $errorHandler = $front->getPlugin('Zend_Controller_Plugin_ErrorHandler');        
		$errorHandler->setErrorHandlerModule($request->getModuleName());
    }
    
}