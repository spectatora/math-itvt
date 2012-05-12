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
 * @package    Tulipa_Bootstrap
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Bootstrap.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Bootstrap Tulipa (c) Site Administration module.
 *
 * @category   Tulipa
 * @package    Tulipa_Bootstrap
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_Application_Module_Bootstrap
 */
class Tulipa_Bootstrap extends Zend_Application_Module_Bootstrap
{
	/**
	 * The folder where the CRUD modules configuration
	 * files are placed.
	 * 
	 * @var string
	 */
	const CRUD_MODULES_FOLDER = '/crud';
	
	/**
	 * @var string
	 */
	const CRUD_MODULES_TRANSLATE_FOLDER = '/crud/translate';
	
    /**
     * Bootstrap autoloader for application resources
     *
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Tulipa_',
            'basePath'  => dirname(__FILE__)
        ));

        return $autoloader;
    }
    
    /**
     * Init CRUD modules
     * 
     * @return void
     */
    protected function _initCrudModules()
    {
        $crudOptions = array(
            'modulesPath' => dirname(__FILE__) . self::CRUD_MODULES_FOLDER
        );
        
        Tulipa_Crud::getInstance($crudOptions)->init();
    }
}