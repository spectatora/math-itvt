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
 * @subpackage Error
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: ErrorController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Errors controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Error
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_ErrorController extends Tulipa_Controller_Action
{
    /**
     * Disable layout.
     * 
     * @return void 
     */
    public function init()
    {
        $this->_helper->layout()->disableLayout();
    }
    
    /**
     * Standart error message.
     * 
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        // Log exception, if logger available
        $log = $this->getLog();
        if ($log) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request = $errors->request;
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
     * Page denied for this ACL Role.
     * 
     * @return void
     */
    public function deniedAction()
    {        
    }
    
    /**
     * Resource not registered in the DB.
     * 
     * @return void
     */
    public function resourceAction()
    {        
    }
}