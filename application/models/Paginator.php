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
 * @subpackage Paginator
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Paginator.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Paginator model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Paginator
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Paginator
{
    /**
     * Make pagination with given adapter and parameters.
     * 
     * @param Zend_Paginator_Adapter_Interface $adapter
     * @param int $page Current page.
     * @param string $variableName Name of the variable that is send to the view
     * @param array $params Other params for the url
     * @param boolean $sendToView Send params directly to the view
     * @param int $itemCountPerPage 
     * @return Zend_Paginator
     */
    public static function create(Zend_Paginator_Adapter_Interface $adapter, $page = 0, 
        $variableName = 'items', $params = null, $sendToView = true, $itemCountPerPage = null
    )
    {
		$paginator = new Zend_Paginator($adapter);
        
        /** If is given, set new item count per page **/
        if (null !== $itemCountPerPage) {
            $paginator->setItemCountPerPage($itemCountPerPage);
        }
        
        if (null === $params) {
            $params = array();
        }
            
        /** Set the current page. **/
		$paginator->setCurrentPageNumber($page);
        
        if ($sendToView) {
            $view = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view;
            
            /** Get the current page items. **/
    		$view->$variableName = (array) $paginator->getCurrentItems();
            /** Init the params **/
            $view->params = array('params' => $params);
            /** Get the paginator itself. **/
    		$view->paginator = $paginator;
        }
        
        return $paginator;        
    }
}