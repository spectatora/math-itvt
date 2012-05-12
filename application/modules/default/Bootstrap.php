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
 * @package    Default_Bootstrap
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Bootstrap.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Bootstrap default module.
 * 
 * @category   Default
 * @package    Default_Bootstrap
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_Application_Module_Bootstrap
 */
class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {    	        
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => dirname(__FILE__)
        ));
        return $autoloader;
    }
}