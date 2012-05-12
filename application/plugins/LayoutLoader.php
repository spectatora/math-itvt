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
 * @subpackage Layouts
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: LayoutLoader.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Load module specific layout.
 * 
 * @category   Application
 * @package    Application_Plugins
 * @subpackage Layouts
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Plugin_LayoutLoader extends Zend_Controller_Plugin_Abstract
{
    /**
     * Load module specific layout.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {        
        $config = Zend_Controller_Front::getInstance()
                                       ->getParam('bootstrap')->getOptions();
        $moduleName = $request->getModuleName();
 
        if (isset($config[$moduleName]['resources']['layout']['layout'])) {
            $layoutScript = $config[$moduleName]['resources']['layout']['layout'];
            Zend_Layout::getMvcInstance()->setLayout($layoutScript);
        }
 
        if (isset($config[$moduleName]['resources']['layout']['layoutPath'])) {
            $layoutPath = $config[$moduleName]['resources']['layout']['layoutPath'];
            Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath);
        }
        
        $layoutPath = $config['resources']['layout']['layoutPath'];
        
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view;
        $view->addScriptPath($layoutPath);
    }
}