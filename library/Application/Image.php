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
 * @package    Application_Image
 * @subpackage Image
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Image.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Image proccessing class (from TomatoCMS).
 * 
 * Factory for image processing.
 * 
 * @category   Application
 * @package    Application_Image
 * @subpackage Image
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Image
{
    /**
     * Factory method.
     * 
     * Get instance of a specific image proccessing adapter. 
     * Implements the {@link http://en.wikipedia.org/wiki/Factory_method_pattern Factory Method} Design Pattern.
     * 
     * @param string $adapter Name of the image adapter
     * @return Application_Image_Abstract|void
     */
    public static function factory($adapter = null)
    {
        if (null === $adapter) {
            return;
        }
        
        if (!is_string($adapter)) {
            return;
        }
        
        $classNamespace = 'Application_Image_';
        
        /**
         * Format the new class name.
         */
        $className = $classNamespace . $adapter;
                
        $fileName = implode(DIRECTORY_SEPARATOR, array(
            dirname(__FILE__), basename(__FILE__, '.php'), $adapter . '.php'
        ));
        
        if (!file_exists($fileName)) {
            return;
        }
        
        /**
         * Check for class existance.
         */        
        if (!class_exists($className)) {
            return;
        }
        
        $adapterObject = new $className;
        
        if ($adapterObject instanceof Application_Image_Abstract) {    
            return new $className;        
        } else {
            return;
        }        
    }
}