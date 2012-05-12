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
 * @subpackage Navigation
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Navigation.php 156 2011-08-04 21:11:45Z sasquatch@bgscripts.com $
 */

/**
 * Main menu navigation.
 * 
 * Using Zend_Navigation load the navigation container array and configure the main menu.
 * 
 * @category   Application
 * @package    Application_Plugins
 * @subpackage Navigation
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
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
                                     
        Zend_Registry::set('Zend_Navigation_Cache', $cache);
        return $cache;
    }
    

    
    /**
     * Create new Zend_Navigation with CRUD modules.
     * 
     * @param array $crudModules
     * @return array
     */
    protected function _getCrudModulesToNavigation()
    {
        $crudModules = Zend_Registry::get(Tulipa_Crud::ZEND_REGISTRY_INDEX);
        $langName = Application_Model_Language::getSessionLang()->name;
        
        foreach ($crudModules as $moduleName => $moduleConfig)
        {
            $moduleTitle = $moduleConfig->name->default;
            
            if (isset($moduleConfig->name->$langName)) {
                $moduleTitle = $moduleConfig->name->$langName;
            }
            
            $nav = array(
                'label' => $moduleTitle,
                'module' => 'tulipa',
                'route' => 'crud',
                //'resource' => $moduleName,
                'controller' => 'crud',
                'params' => array('crudModuleName' => $moduleName),
                'pages' => array(
                    array(
                        'label' => Application_Model_Translate::translate("Create new"),
                        'module' => 'tulipa',
                		'route' => 'crud',
                		'params' => array('crudModuleName' => $moduleName),
                        'action' => 'add',
                		//'resource' => $moduleName,
                        //'privilege' => 'add',
                        'controller' => 'crud',
                        'class' => 'hidden'
                    ),
                    array(
                        'label' => Application_Model_Translate::translate("Edit"),
                        'module' => 'tulipa',
                        'action' => 'edit',
                        'controller' => 'crud',
                		'route' => 'crud',
                		'params' => array('crudModuleName' => $moduleName),
                		//'resource' => $moduleName,
                        //'privilege' => 'edit',
                        'class' => 'hidden'
                    )
                )
            );
            
            if (isset($moduleConfig->hidden)) {
                if ($moduleConfig->hidden) {
                    $nav['class'] = 'hidden';
                }
            }
            
            $pages[] = $nav;
        }
        
        if (isset($pages)) {                     
            $navigation = array(
                array(
                    'label' => Application_Model_Translate::translate("CRUD modules"),
                    'module' => 'tulipa',
                    'pages' => $pages
                )
            );
        }
        
        if (isset($navigation)) {
            return $navigation;
        } else {
            return null;
        }
    }
    
    /**
     * Loads the Zend_Navigation container array and 
     * configures the Zend_Navigation.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        /** No languages needed in command line mode **/
        if (defined('CLI_MODE')) {
            return;
        }
                
        /** Cache **/
        $cache = $this->_getCacheInstance();
        $cacheId = 'Zend_Navigation_' . $request->getModuleName() 
                                      . '_' . $request->getControllerName() 
                                      . '_' . $request->getActionName();
        $cacheId = md5($cacheId);
        
        if (!($navigation = $cache->load($cacheId)) or !($navigationArray = $cache->load($cacheId . 'Array'))) {            
            /** Get navigation files for the current module. **/
            $navigationFilesDir = $this->getNavigationFilesDir();
            $filesRegexPattern = '/^[a-zA-Z0-9]+\.php$/';
            if (is_dir($navigationFilesDir)) {            	
            	foreach (new DirectoryIterator($navigationFilesDir) as $file) 
            	{
	            	/** Get only the php files. **/
                    if (preg_match($filesRegexPattern, $file)) {
                        $navigationName = basename($file, '.php');
                        $navigationArray[$navigationName] = $this->_loadNavigationFile($file);
                        $navigation[$navigationName] = new Zend_Navigation($navigationArray[$navigationName]);
                    }
            	}
            }
            
            if (empty($navigation)) {
                return;
            }
            
            $cache->save($navigation, $cacheId, array('Zend_Navigation'));
            $cache->save($navigationArray, $cacheId . 'Array', array('Zend_Navigation'));
        }
        
        $crudModulesNavigation = $this->_getCrudModulesToNavigation();
        
        $navigationArray['crudModules'] = $crudModulesNavigation;
        $navigation['crudModules'] = new Zend_Navigation($crudModulesNavigation);
        
        
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view;
        
        $view->navigation = $navigation;
        $view->mixedNavigation = new Zend_Navigation(self::arrayMerge($navigationArray));
        $view->mixedNavigationArray = self::arrayMerge($navigationArray);
                
        
        
        Zend_Registry::set('Zend_Navigation', $view->mixedNavigation);
        
        $view->navigation()
             ->setAcl(Zend_Registry::get('Zend_Acl'))
             ->setRole(Zend_Registry::get('Zend_Acl_Role'))
             ->menu()
             ->setOnlyActiveBranch(false);
        
    }
    
    /**
     * Merge subarray's of one array.
     * 
     * @param array $array
     * @return array
     */
    public static function arrayMerge($array)
    {
        $newArray = array();
        foreach ($array as $key=>$value) 
        {
            $newArray = array_merge($newArray, $value);
        }
        
        return $newArray;
    }   
     
    /**
     * Get the navigation files directory
     * 
     * @return string
     */
    public function getNavigationFilesDir()
    {
    	
        $options = Zend_Controller_Front::getInstance()->getParam('bootstrap')
                                                       ->getApplication()
                                                       ->getOptions();
        /**
         * Get the modules directory
         */
        $modulesPath = $options['resources']['frontController']['moduleDirectory'];
                
        return implode(DIRECTORY_SEPARATOR, array(
                   $modulesPath, $this->getRequest()->getModuleName(), 'configs', 'navigation'
               ));
    }
    
    /**
     * Load navigation array file.
     * 
     * @param string $fileName
     * @return array
     */
    protected function _loadNavigationFile($fileName = null)
    {        
        if (null === $fileName) {
            return array();
        } else {     
            $configDir = $this->getNavigationFilesDir();
            return (array) include(realpath(implode(DIRECTORY_SEPARATOR, array($configDir, $fileName))));
        }
    }
}