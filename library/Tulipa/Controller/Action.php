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
 * @package    Tulipa_Controller
 * @subpackage Action
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Action.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Abstract controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controller
 * @subpackage Action
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
abstract class Tulipa_Controller_Action extends Application_Controller_Action
{    
    /**
     * Check is the request from JavaScript.
     * 
     * If the request is send via ajax - disable layouts.
     * 
     * @return void
     */
    public function preDispatch()
    {
        $request = $this->getRequest();
                
        $requestName = Zend_Filter::filterStatic($request->getParam('request'), 'alnum');
        $layout = Zend_Filter::filterStatic($request->getParam('layout', null), 'alnum');
        
        if ($request->isXmlHttpRequest() or $requestName === 'ajax') {
            /**
             * If the request is via Ajax, change the layout
             */
            $this->_helper->layout->setLayout('ajax');
        }
        
        if (!empty($layout)) {
            if ($layout === 'document') {
                $this->_helper->layout->setLayout('document');
            }
        }
    }
}