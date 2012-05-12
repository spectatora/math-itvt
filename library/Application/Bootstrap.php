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
 * @package    Application_Bootstrap
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Bootstrap.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Main bootstrap.
 * 
 * @category   Application
 * @package    Application_Bootstrap
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_Application_Bootstrap_Bootstrap
 */
class Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{        
    /**
     * Load common settings.
     * 
     * @return void
     */
    protected function _initCommonSettings()
    {        
        $iniPath = implode(DIRECTORY_SEPARATOR, array(
            APPLICATION_PATH,
            'configs',
            'common.ini'
        ));
        
        $commonSettings = new Zend_Config_Ini($iniPath, APPLICATION_ENV);
        
        Zend_Registry::set('COMMON_SETTINGS', $commonSettings);
    }
    
    /**
     * Cache page output.
     * 
     * @return void
     */
    protected function _initPageCache()
    {
    	/** No page cache in command line mode **/
        if (defined('CLI_MODE')) {
            return;
        }
        
        $frontendOptions = array(
           	'lifetime' => 300000,
            'automatic_serialization' => true,
           	'debug_header' => APPLICATION_ENV != 'production',
        	'caching' => true,
            'default_options' => array(
                'cache_with_cookie_variables' => true,
                'make_id_with_cookie_variables' => false,
            ),
            'regexps' => array(
               '^/(.+)' => array(
                   	'cache' => true
               ),
               '^/(.+?)/$' => array(
                   	'cache' => false
               ),
               '^/$' => array('cache' => false)
            )
        );

        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/../cache/',
            'file_name_prefix' => 'PAGE_CACHE_' . strtoupper(APPLICATION_ENV)
        );

        $cache = Zend_Cache::factory('Page',
                                     'File',
                                     $frontendOptions,
                                     $backendOptions);
        
        if (Zend_Registry::get('COMMON_SETTINGS')->caching->page) {                                     
            $cache->start();
        }
        
        Zend_Registry::set('PAGE_CACHE', $cache);
    }
    
    /**
     * Configure cache manager.
     * 
     * @return void
     */
    protected function _initCacheManager()
    {        
        $caching = Zend_Registry::get('COMMON_SETTINGS')->caching;
                
        $cacheManager = new Zend_Cache_Manager;
        
        $commonCache = array(
            'frontend' => array(
                'name' => 'Core',
                'options' => array(
                    'lifetime' => null,
                	'caching' => $caching->common,
                    'cache_id_prefix' => APPLICATION_ENV . '_COMMON',
                    'debug_header' => false,
                    'automatic_serialization' => true
                )
            ),
            'backend' => array(
                'name' => 'File',
            	'options' => array(
                    'cache_dir' => APPLICATION_PATH . '/../cache/',
                    'file_name_prefix' => APPLICATION_ENV  . '_COMMON'
                )
            )
        );
        
        $cacheManager->setCacheTemplate('commonCache', $commonCache);
        
        $unserializedCache = array(
            'frontend' => array(
                'name' => 'Core',
                'options' => array(
                    'lifetime' => null,
                	'caching' => $caching->unserialized,
                    'cache_id_prefix' => APPLICATION_ENV . '_UNSERIALIZED',
                    'debug_header' => false,
                    'automatic_serialization' => true
                )
            ),
            'backend' => array(
                'name' => 'File',
            	'options' => array(
                    'cache_dir' => APPLICATION_PATH . '/../cache/',
                    'file_name_prefix' => APPLICATION_ENV  . '_UNSERIALIZED'
                )
            )
        );
        
        $cacheManager->setCacheTemplate('unserializedCache', $unserializedCache);
                
        Zend_Registry::set('CACHE_MANAGER', $cacheManager);
        
        /**
         * PluginLoader cache
         */
        $classFileIncCache = APPLICATION_PATH . '/../cache/pluginLoaderCache.php';
        if (file_exists($classFileIncCache)) {
            include_once $classFileIncCache;
        }
        
        /** Zend_Loader_PluginLoader **/       
        Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);        
    }
    
    /**
     * Configure MySQL settings.
     * 
     * Define mysql db table name prefix and add metadata cache.
     * 
     * @return Bootstrap
     */
    protected function _initMySQL()
    {        
        
        /** Make db table cache **/
        $frontend = new Zend_Cache_Core(array(
            'automatic_serialization' => true,
            'cache_id_prefix'         => 'meta',
            'lifetime'                => null
        ));
        
        $backend = new Zend_Cache_Backend_File(array(
            'cache_dir' => APPLICATION_PATH . '/../cache',
            'file_name_prefix' => APPLICATION_ENV  . '_metadata'
        ));
        
        $cache = Zend_Cache::factory($frontend, $backend);
        
        Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
        
        return $this;
    }
    
    /**
     * Remove slashes if magic quotes are on.
     * 
     * @return void
     */
    protected function _initMagicQuotes()
    {
        /** Check are magic quotes enabled **/
        $magicQuotesEnabled = (bool) ini_get('magic_quotes_gpc');
        if ($magicQuotesEnabled === true) {            
            /** Remove slashes from $_GET **/
            if (isset($_GET) && !empty($_GET)) {
                $this->_stripSlashesFromArray($_GET);
            }
            /** Remove slashes from $_POST **/
            if (isset($_POST) && !empty($_POST)) {
                $this->_stripSlashesFromArray($_POST);
            }
            /** Remove slashes from cookies **/
            if (isset($_COOKIE) && !empty($_COOKIE)) {
                $this->_stripSlashesFromArray($_COOKIE);
            }            
        }
    }
    
    /**
     * Strip slashes from array
     * 
     * @return array
     */
    protected function _stripSlashesFromArray(&$value)
    {
        if (is_array($value)) {
            foreach ($value as $key=>$result)
            {
                if (is_array($result)) {
                    $value[$key] = $this->_stripSlashesFromArray($result);
                } else {
                    $value[$key] = stripslashes($result);
                }
            }
        } else {
            $value = stripslashes($value);
        }
            
        return $value;
    }
    
    /**
     * Bootstrap TulipaCore directories.
     * 
     * @return void
     */
    protected function _initDirectories()
    {
        define('TULIPA_PATH', realpath(dirname(__FILE__) . '/../../'));             
    }
    
    /**
     * Validates the domain name from a list.
     * 
     * @return void
     */
    protected function _initAllowedDomains()
    {
        /** No check in command line mode **/
        if (defined('CLI_MODE')) {
            return;
        }
        
        $iniPath = implode(DIRECTORY_SEPARATOR, array(
            APPLICATION_PATH, 'configs', 'allowed-domains.ini'
        ));
        
        $allowedDomainsConfig = new Zend_Config_Ini($iniPath, APPLICATION_ENV);
        
        if (empty($allowedDomainsConfig->allowed)) {
            return;
        }
        
        $allowedDomains = $allowedDomainsConfig->allowed->toArray();
        $currentDomain = $_SERVER['HTTP_HOST'];
                
        if (!in_array($currentDomain, $allowedDomains)) {
            exit;
        }
    }
    
    /**
     * Load routes.ini and initilize router.
     * 
     * @return void
     */
    protected function _initRoutes()
    {
        /** No router usage in command line mode **/
        if (defined('CLI_MODE')) {
            return;
        }
        
        /** Get the rewrite router object object **/
        $router = Zend_Controller_Front::getInstance()->getRouter();
        
        $cacheManager = Zend_Registry::get('CACHE_MANAGER');
        $cache = $cacheManager->getCache('commonCache');
        
        $cacheId = 'routes';
        
        /** Cache the menu links **/
        if (!($routesIni = $cache->load($cacheId))) {
            
            $iniPath = implode(DIRECTORY_SEPARATOR, array(
                APPLICATION_PATH,
                'configs',
                'routes.ini'
            ));
            
            if (file_exists($iniPath)) {
                $routesIni = new Zend_Config_Ini($iniPath, APPLICATION_ENV);
            }
            
            $cache->save($routesIni, $cacheId, array($cacheId));
        }
        
        $router->addConfig($routesIni, 'routes');
    }
    
    /**
     * Configure Zend_Paginator.
     * 
     * @return void
     */
    protected function _initPaginator()
    {
        /** Get the items per page limit. **/
        $commonSettings = Zend_Registry::get('COMMON_SETTINGS');
        $paginatorSettings = $commonSettings->paginator;
        
        /** Set the default scrolling style. **/
        Zend_Paginator::setDefaultScrollingStyle($paginatorSettings->defaultScrollingStyle);
        Zend_Paginator::setDefaultItemCountPerPage($paginatorSettings->defaultItemCountPerPage);
                
        /** Set the default view partial. **/
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(
          'paginator/partial.phtml'
        );
    }
    
    /**
     * Bootstrap TulipaCore application autoloading.
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initApplicationAutoloader()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Application_',
            'basePath'  => TULIPA_PATH . '/application'
        ));
        return $autoloader;
    }
    
    /**
     * Bootstrap TulipaCore default module autoloading.
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initDefaultAutoloader()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => TULIPA_PATH . '/application/modules/default'
        ));
        return $autoloader;
    }
    
    /**
     * Bootstrap TulipaCore tulipa module autoloading.
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initTulipaAutoloader()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Tulipa_',
            'basePath'  => TULIPA_PATH . '/application/modules/tulipa'
        ));
        return $autoloader;
    }
}
