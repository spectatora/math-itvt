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
 * @package    Tulipa_Plugins
 * @subpackage View
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: View.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Assing some variables to Zend_View.
 * 
 * @category   Tulipa
 * @package    Tulipa_Plugins
 * @subpackage View
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Plugin_View extends Zend_Controller_Plugin_Abstract
{
    /**
     * Assing some variables to Zend_View.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        /**
         * Only for the Tulipa module.
         */
        if ($request->getModuleName() === 'tulipa') {
            
            /** Get the view object **/
            $view = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer')->view;
            $commonSettings = Zend_Registry::get('COMMON_SETTINGS');
            $view->title = $commonSettings->title;
            $view->headTitle()->setSeparator(" :: ");
            
            $pageCache = Zend_Registry::get('PAGE_CACHE');
            $pageCache->cancel();
            
        }
    }
}