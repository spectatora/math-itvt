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
 * @package    Application_Controller
 * @subpackage Action
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Action.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Abstract controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Application
 * @package    Application_Controller
 * @subpackage Action
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
abstract class Application_Controller_Action extends 
    Zend_Controller_Action
{
    /**
     * Common settings.
     * 
     * @var Zend_Config_Ini
     */
    protected $_settings = null;
    
    /**
     * Load common settings.
     * 
     * @return void
     */
    public function init()
    {        
        
        /**
         * Load common settings and save them 
         * to a protected variable.
         */
        $this->_settings = Zend_Registry::get('COMMON_SETTINGS');
        $this->view->settings = $this->_settings;
    }
    
    /**
     * Get current user id.
     * 
     * Get the id attribute saved in the Zend_Auth session storage.
     * 
     * @return int|null
     * @throws Zend_Controller_Action_Exception
     */
    protected function _getUserId()
    {        
        $userId = Zend_Auth::getInstance()->getIdentity()->id;
        
        if (empty($userId)) {
            throw new Zend_Controller_Action_Exception('User is not authenticated');
        }
        return $userId;
    }
    
    /**
     * Shortcut to Translate View Helper.
     * 
     * @return string
     */
    public function translate()
    {
        /** Get view **/
		$view = $this->view;
		$args = func_get_args();
		return call_user_func_array(array($view, 'translate'), $args);
    }
    
    /**
     * Shortcut to getPost()
     * 
     * @param string $key
     * @param string $default Default if value if $paramName is not set
     * @return mixed
     */
    protected function _getPost($key = null, $default = null)
    {
        return $this->getRequest()->getPost($key, $default);
    }
    
    /**
     * Get array with values of the requested params.
     * 
     * @param array $params
     * @param boolean $ignoreEmpty Ignore params with empty values
     * @return array
     */
    protected function _getParams(array $params, $ignoreEmpty = false)
    {
        $paramValues = array();
        foreach ($params as $paramName)
        {
            $paramValue = $this->_getParam($paramName);
            if (isset($paramValue)) {
                $paramValues[$paramName] = $paramValue;
            }
        }
        return $paramValues;
    }
    
    /**
     * Generates an url given the name of a route.
     *
     * @param  array $urlOptions Options passed to the assemble method of the Route object.
     * @param  mixed $name The name of a Route to use. If null it will use the current Route
     * @param  bool $reset Whether or not to reset the route defaults with those provided
     * @return string Url for the link href attribute.
     */
    public function url($urlOptions = null, $name = 'default', $reset = true, $encode = true)
    {
        $urlOptions = $urlOptions === null ? array() : $urlOptions;
        return $this->view->url($urlOptions, $name, $reset, $encode);
    }
    
    /**
     * Shortcut to status action controller helper.
     * 
     * @param string $statusMessage
     * @param string $statusType
     * @param boolean $isError
     */
    public function status($statusMessage = null, $statusType = 'success', $isError = false)
    {
        return $this->_helper->status($statusMessage, $statusType, $isError);
    }
    
    /**
     * Get status messages array.
     * 
     * @return array|null
     */
    public function getStatus()
    {
        return $this->_helper
                    ->getHelper('Status')
                    ->getStatusMessages();
    }
    
    /**
     * Outputs json coded array with status messages.
     * 
     * @return void
     */
    public function outputStatusJson()
    {
        return $this->_helper->json($this->getStatus());
    }
    
    /**
     * Get options set in application.ini
     * 
     * @param $returnObject Return as object
     * @return array
     */
    protected function _getApplicationOptions($returnObject = false)
    {
        $options = $this->getFrontController()
                        ->getParam('bootstrap')
                        ->getApplication()
                        ->getOptions();
        
        if ($returnObject) {
            return (object) $options;
        }
        
        return $options;
    }
}