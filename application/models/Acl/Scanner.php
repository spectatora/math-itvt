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
 * @version    $Id: Scanner.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Scan controller files.
 * 
 * Opens the controller directory and scans
 * for controller files. Another scan searches all
 * actions in the founded controller files.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl_Scanner
{
    /**
     * Scan modules folder.
     * 
     * Opens the modules directory and gets all avaliable modules.
     * 
     * @return array|boolean
     */
    public static function scanModules()
    {
        $modules = false;
        
        $options = Zend_Controller_Front::getInstance()->getParam('bootstrap')
                                                       ->getApplication()
                                                       ->getOptions();
        /**
         * Get the modules directory
         */
        $modulesPath = $options['resources']['frontController']['moduleDirectory'];
        
        if (is_dir($modulesPath)) {
            /** Using DirectoryIterator to iterate the modules directory **/
    	    $modulesDirectory = new DirectoryIterator($modulesPath);
    	    
    	    foreach ($modulesDirectory as $fileinfo) 
    	    {
    	        $filename = $fileinfo->getFilename();
    	        if (!$fileinfo->isDot() && $fileinfo->isDir() && $filename[0] != '.') {
    	            $modules[] = $filename;
    	        }
    	    }
        }
        
        return $modules;
    }
    
    /**
     * Scan controller files.
     * 
     * Opens the controller directory for the given module
     * and scans for controller files. Another scan searches
     * all actions in the founded controller files.
     * 
     * @param string $module Module to scan
     * @return array|boolean
     */
    public static function scanControllers($module = null)
    {
        $frontController = Zend_Controller_Front::getInstance();

        $controllerDir = $frontController->getControllerDirectory($module);
        
        if (empty($controllerDir)) {
            return false;
        }
        
        $controllerDir = realpath($controllerDir);

        $controllerFiles = false;
        $controllersRegexPattern = '/^[a-zA-Z]+Controller\.php$/';
        $actionsRegexPattern = '/^[a-zA-Z]+Action$/';

        if (is_dir($controllerDir)) {
            /** Using DirectoryIterator to iterate the controllers directory **/
    	    $controllersDirectory = new DirectoryIterator($controllerDir);
    	    
    	    foreach ($controllersDirectory as $fileinfo) 
    	    {
    	        $file = $fileinfo->getFilename();
    	    	/**
                 * Get only the controller files.
                 */
                if (preg_match($controllersRegexPattern, $file)) {
                    
                    $controllerClassName = basename($file, '.php');
                    
                    $controllerName = basename($controllerClassName, 'Controller');
                    
                    if ($module != 'default') {
                        $controllerClassName = ucfirst($module) . '_' . $controllerClassName;
                        Zend_Loader::loadFile($file, $controllerDir, true);
                    }
                    
                    Zend_Loader::loadClass($controllerClassName, $controllerDir);
                    
                    /**
                     * Use the reflection to get all existing methods
                     * in the controller class.
                     */
                    $class = new ReflectionClass($controllerClassName);
                    $methods = $class->getMethods();
                    
                    $camelCaseToDashFilter = new Zend_Filter_Word_CamelCaseToDash;
                    $controllerName = $camelCaseToDashFilter->filter($controllerName);
                    
                    /**
                     * Search methods for action methods
                     * and store only them.
                     */
                    foreach ($methods as $value) {
                        if (preg_match($actionsRegexPattern, $value->name)) {
                            $controllerFiles[strtolower($controllerName)][] = strtolower($camelCaseToDashFilter->filter(
                                basename($value->name, 'Action')));
                        }
                    }
                }
    	    }
        }

        return $controllerFiles;
    }
}
?>