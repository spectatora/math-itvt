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
 * @category   Default
 * @package    Default_Controllers
 * @subpackage Error
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: ErrorController.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Errors controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Default
 * @package    Default_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class ErrorController extends Default_Controller_Action
{   
    
    /**
     * Disable page cache.
     * 
     * @see Application_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        Zend_Registry::get('PAGE_CACHE')->cancel();
    }
    
    /**
     * Standart error message.
     * 
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = $this->translate('Page not found');
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        $log = $this->getLog();
        if ($log) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }
    
    /**
     * Get log message.
     * 
     * @return string
     */
    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }
    
    /**
     * Resource not found.
     * 
     * @return void
     */
    public function resourceAction()
    {
        $this->status($this->translate('Error 404 - Page not found'), 'error', true);
        $this->render('resource');
    }
    
    /**
     * Page denied for those ACL Role.
     * 
     * @return void
     */
    public function deniedAction()
    {        
    }
}