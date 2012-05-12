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
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Acl.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * ACL model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl
{
    const HIERARCHY_SEPARATOR = '::';
    
    /**
     * Contains Acl Roles in array.
     * @var array
     */
    public static $_roles = null;
    
    /**
     * Singleton instances of frequently used adapters.
     * @var array
     */
    protected static $_instances = array();
    
    /**
     * Get Acl itself from the DB Table.
     * 
     * Get Acl Access model instance with Factory Method
     * and select all registered rules in the DB Table.
     * 
     * @return array|null
     */
    public static function browseAcl()
    {
        return self::factory('access', true)->browse();
    }
    
    /**
     * Get all resources from the DB Table.
     * 
     * Get Acl Resources model instance with Factory Method
     * and select all registered Acl Resources in the DB Table.
     * 
     * @return array|null
     */
    public static function browseResources()
    {
        return self::factory('resources', true)->browse();
    }
    
    /**
     * Get all roles from the DB Table.
     * 
     * Get Acl Roles model instance with Factory Method
     * and select all registered Acl Roles in the DB Table.
     * 
     * @return array|null
     */
    public static function browseRoles()
    {
        if (self::$_roles === null) {
            self::$_roles = self::factory('roles', true)->browse();
        }
        
        return self::$_roles;
    }
    
    /**
     * Get the default role from the DB Table.
     * 
     * Get Acl Roles model instance with Factory Method
     * and get the default Acl Role.
     * 
     * @param string $default
     * @return array|null
     */
    public static function readRoleByDefault($default = null)
    {
        $cacheManager = Zend_Registry::get('CACHE_MANAGER');
        $cache = $cacheManager->getCache('commonCache');
        
        $cacheId = 'defaultRole' . ucfirst($default);
        
        if (!($roleByDefault = $cache->load($cacheId))) {
            
            $roleByDefault = self::factory('roles', true)->readRoleByDefault($default);
            
            $cache->save($roleByDefault, $cacheId, array('defaultRole'));
        }
        
        return $roleByDefault;
    }
    
    /**
     * Get role details by id from the DB Table.
     * 
     * Get Acl Roles model instance with Factory Method
     * and get Acl Role by id.
     * 
     * @param int $id
     * @return array|null
     */
    public static function readRoleById($id = null)
    {
        return self::factory('roles', true)->setId($id)
                                           ->read();
    }
    
    /**
     * Get all registered privileges for one Acl Resource from the DB Table.
     * 
     * Get Acl Privileges model instance with Factory Method
     * and select all Acl Privileges registered with the given
     * Acl Resource ID from the DB Table.
     * 
     * @param int $resourceId
     * @return array|null|void
     */
    public static function readPrivilegesByResourceId($resourceId = null)
    {
        if (null === $resourceId || !is_int($resourceId)) {
            return;
        }
        
        return self::factory('privileges', true)->setResourceId($resourceId)
                                                ->readByResourceId();                
    }
    
    /**
     * Factory method.
     * 
     * Get instance of a specific Acl Component. 
     * Implements the {@link http://en.wikipedia.org/wiki/Factory_method_pattern Factory Method} Design Pattern.
     * 
     * @param string $adapterName Name of the acl component
     * @param boolean $getSingleton Get the instance from the stack (something like singleton instance). 
     *                              If no instance registered, create one.
     * @return Application_Model_Acl_Adapter_Abstract|void
     */
    public static function factory($adapterName = null, $getSingleton = false)
    {
        if (null === $adapterName) {
            return;
        }
        
        if (!is_string($adapterName)) {
            return;
        }
        
        /**
         * Format the new class name.
         */
        $className = 'Application_Model_Acl_Adapter_' . ucfirst($adapterName);
                
        /**
         * Check for class existance.
         */        
        if (!class_exists($className)) {
            return;
        }
        
        if ($getSingleton) {
            if (array_key_exists(strtolower($adapterName), self::$_instances)) {
                return self::$_instances[strtolower($adapterName)];
            } else {
                $object = new $className;                
                if ($object instanceof Application_Model_Acl_Adapter_Abstract) { 
                    self::$_instances[strtolower($adapterName)] = $object;
                    return $object;
                } else {
                    throw new Zend_Exception("Adapter class '$adapterName' does not extend Application_Model_Acl_Adapter_Abstract");
                }
            }
        } else {
            $object = new $className;
            if ($object instanceof Application_Model_Acl_Adapter_Abstract) { 
                return $object;
            } else {
                throw new Zend_Exception("Adapter class '$adapterName' does not extend Application_Model_Acl_Adapter_Abstract");
            }
        }      
    }
    
    /**
     * Compare real resources with these in the DB Table.
     * 
     * Update the differences.
     * 
     * @return void
     */
    public static function compare()
    {
        $modules = Application_Model_Acl_Scanner::scanModules();
        
        if (!$modules) {
            return;
        }
        
        foreach ($modules as $module)
        {
            /**
             * Get the real controllers.
             */
            $realControllers = Application_Model_Acl_Scanner::scanControllers($module);
            /**
             * Get resources.
             */
            $resourcesModel = self::factory('resources');
            $resources = $resourcesModel->browseReady();
            /**
             * Privileges model.
             */
            $privilegesModel = self::factory('privileges');
            
            if (!$realControllers) {
                continue;
            }
            
            /**
             * STAGE 1: Check are all controllers registered.
             * 
             * Check if all controllers and actions are registered
             * in the DB Table.
             */
            foreach ($realControllers as $controller => $actions)
            {
                $resourceName = strtolower($module . self::HIERARCHY_SEPARATOR . $controller);
                
                /**
                 * If no resources are registered,
                 * insert all resources an priviliges to the DB Table.
                 */
                if (empty($resources)) {
                    $resourcesModel->setName($resourceName)
                                   ->insert();
                    
                    $privilegesModel->setResourceId($resourcesModel->getId());
                    
                    foreach ($actions as $action) {
                        $privilegesModel->setName($action)
                                        ->insert();
                    }
                    
                    continue;
                }
                
                /**
                 * Check if the controller exists in the resources
                 * DB Table. If so - insert it and it`s actions.
                 */
                if (!in_array($resourceName, $resources)) {
                    
                    /**
                     * Add the new resource to the DB Table
                     * and get it`s primary key id.
                     */
                    $resourcesModel->setName($resourceName)
                                   ->insert();
                    $controllerId = $resourcesModel->getId();
                    $privilegesModel->setResourceId($controllerId);
                                    
                    foreach ($actions as $action)
                    {
                        $privilegesModel->setName($action)
                                        ->insert();
                    }
                    
                } else {
                    $controllerId = array_search($resourceName, $resources);
                    $privileges = $privilegesModel->setResourceId($controllerId)
                                                  ->readByResourceIdReady();
                    
                    foreach ($actions as $action)
                    {
                        $privilegesModel->setName($action);
                        if (!empty($privileges)) {
                            if (!in_array($action, $privileges)) {
                                $privilegesModel->insert();
                            }
                        } else {
                            $privilegesModel->insert();
                        }
                    }
                }
            }
            
            if (empty($resources)) {
                $resources = $resourcesModel->browseReady();
            }
            
            /**
             * STAGE 2: Check for "dead" resources and privileges.
             * 
             * Check for each registered resource and it`s privileges
             * that have appropriate controller and actions.
             */
            foreach ($resources as $resourceId => $resourceName)
            {
                $resourceControllerName = explode(self::HIERARCHY_SEPARATOR, $resourceName);
                if ($resourceControllerName[0] == $module & !empty($resourceControllerName[1])) {
                    if (!array_key_exists($resourceControllerName[1], $realControllers)) {
                        /**
                         * If the resource doesn`t has appropriate controller,
                         * delete it.
                         */
                        $resourcesModel->setId($resourceId)
                                       ->delete();
                    } else {
                        $privilegesModel->setResourceId($resourceId);
                        $privileges = $privilegesModel->readByResourceIdReady();
                        
                        foreach ($privileges as $privilege)
                        {
                            if (!in_array($privilege, $realControllers[$resourceControllerName[1]])) {
                                $privilegesModel->setName($privilege)
                                                ->delete();
                            }
                        }
                        
                    }
                }
                
            }
            
            /**
             * STAGE 3: Add module-only resources.
             */
            $moduleOnlyResource = $module . self::HIERARCHY_SEPARATOR;
            
            if (!in_array($moduleOnlyResource, $resources))
            {
                $resourcesModel->setName($moduleOnlyResource)
                               ->insert();
            }
        }
    }
}