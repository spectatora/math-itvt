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
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Acl.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Proccess the Acl mechanism.
 * 
 * @category   Application
 * @package    Application_Plugins
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var Zend_Acl
     */
    protected $_acl = null;
    
    /**
     * Set Acl.
     * 
     * @param Zend_Acl
     * @return Zend_Controller_Plugin_Abstract
     */
    public function setAcl($acl)
    {
        $this->_acl = $acl;
        return $this;
    }
    
    /**
     * Get Acl.
     * 
     * If Application_Plugin_AclCheck::_acl is null,
     * create new Acl.
     * 
     * @return Zend_Acl
     */
    public function browseAcl()
    {
        if (null === $this->_acl) {
            $acl = $this->_createAcl();
        } else {
            $acl = $this->_acl;
        }
        return $acl;
    }
    
    /**
     * Get Zend_Cache instance.
     * 
     * Using Core Frontend.
     * 
     * @return Zend_Cache_Core|Zend_Cache_Frontend
     */
    protected function _getCacheInstance()
    {
        $frontendOptions = array(
            'lifetime' => null,
            'cache_id_prefix' => basename(__FILE__, '.php') . '_',
            'debug_header' => false,
            'automatic_serialization' => true
        );
         
        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/../cache/',
            'file_name_prefix' => APPLICATION_ENV  . '_' . basename(__FILE__, '.php')
        );
        
        $cache = Zend_Cache::factory('Core',
                                     'File',
                                     $frontendOptions,
                                     $backendOptions);
        
        Zend_Registry::set('Zend_Acl_Cache', $cache);
        
        return $cache;
    }
        
    /**
     * Create Acl.
     * 
     * Get Acl Roles, Acl Resources and Acl itself from DB Table
     * and apply them.
     * 
     * @return Zend_Acl
     */
    protected function _createAcl()
    {
        $acl = new Zend_Acl;
        
        /**
         * Get all Acl Roles from DB Table and 
         * add them to the Zend_Acl instance.
         */
        $dbAclRoles = Application_Model_Acl::browseRoles();
                
        foreach ($dbAclRoles as $role) {
            $acl->addRole(new Zend_Acl_Role($role['name']), $role['parentName']);
        }
        
        /**
         * Add modules as resources parents.
         */
        $modules = Application_Model_Acl_Scanner::scanModules();
                
        foreach ($modules as $module) {
            $acl->addResource(new Zend_Acl_Resource($module . Application_Model_Acl::HIERARCHY_SEPARATOR));
        }
        
        /**
         * Get all Acl Resources from DB Table and 
         * add them to the Zend_Acl instance.
         */
        $dbAclResources = Application_Model_Acl::browseResources();
        
        foreach ($dbAclResources as $resource) {
            
            if ($acl->has($resource['name'])) {
                continue;
            }
            
            $resourceSplit = explode(Application_Model_Acl::HIERARCHY_SEPARATOR, $resource['name']);
            $parentName = $resourceSplit[0] . Application_Model_Acl::HIERARCHY_SEPARATOR;
            
            $acl->addResource(new Zend_Acl_Resource($resource['name']), $parentName);
        }
        
        /**
         * Finaly get the Access Control List and apply it
         * to the Zend_Acl.
         */
        $dbAcl = Application_Model_Acl::browseAcl();
        
        foreach ($dbAcl as $access) {
            if ($access['allow']) {
                $operation = 'allow';
            } else {
                $operation = 'deny';
            }
            
            $acl->$operation($access['roleName'], $access['resourceName'], $access['privilegeName']);
        }
        
        return $acl;
    }
    
	/**
	 * Front controller dispatch.
	 * 
	 * Defines is the visited place accessible by the current role.
	 * 
	 * @param Zend_Controller_Request_Abstract $request
	 * @return void
	 */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        
        /** No ACL needed in command line mode **/
        if (defined('CLI_MODE')) {
            return;
        }
        
        /**
         * Create the Acl.
         */
        $cache = $this->_getCacheInstance();
        $cacheId = 'Zend_Acl';
        if (!($acl = $cache->load($cacheId))) {
            $acl = $this->browseAcl();
            $cache->save($acl, $cacheId, array('Zend_Acl'));
        }
        
        Zend_Registry::set('Zend_Acl', $acl);        
                        
        /** Check if user has identity **/
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $userIdentity = Zend_Auth::getInstance()->getIdentity();
            $roleArray = Application_Model_Acl::factory('roles')
                                              ->setId($userIdentity->roleId)
                                              ->read();
            $role = $roleArray['name'];
        } else {
            /**
             * If user is not identified, 
             * get the default role name
             */
            $defaultRole = Application_Model_Acl::readRoleByDefault(Application_Model_Acl_Adapter_Roles::DEFAULT_GUEST);
            $role = $defaultRole['name'];
        }
        
        Zend_Registry::set('Zend_Acl_Role', $role);
        
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        $resource = $module . Application_Model_Acl::HIERARCHY_SEPARATOR . $controller;
                
        $privilege = strtolower(Zend_Filter::filterStatic($action, 'Word_CamelCaseToDash'));
                
        if (!$acl->has($resource)) {
            $this->_goToErrorPage($request, $module);
            return;
            $resource = null;
        }
        
        if (!$acl->isAllowed($role, $resource, $privilege)) {
            $this->_goToDeniedPage($request, $module);
        } else {
            if ($request->getModuleName() == 'tulipa') {
                $ckFinderSession = new Zend_Session_Namespace('CKFinder');                
                $ckFinderSession->allowed = true;
                $ckFinderSession->baseUrl = $request->getBaseUrl();
            }
        }
    }
    
    /**
     * Redirect to error page.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @param string $module
     * @return void
     */
    protected function _goToErrorPage(Zend_Controller_Request_Abstract $request, $module)
    {
        $this->_goToPage($request, $module, 'error', 'resource');
    }
    
    /**
     * Redirect to the denied error page.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @param string $module
     * @return void
     */
    protected function _goToDeniedPage(Zend_Controller_Request_Abstract $request, $module)
    {
        $this->_goToPage($request, $module, 'error', 'denied');
    }
    
    /**
     * Redirect to a speicific page.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return void
     */
    protected function _goToPage(Zend_Controller_Request_Abstract $request, $module, $controller, $action)
    {
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
    }
}