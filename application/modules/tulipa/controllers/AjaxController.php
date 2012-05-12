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
 * @package    Tulipa_Controllers
 * @subpackage Ajax
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: AjaxController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for handling ajax requests.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Ajax
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_AjaxController extends Tulipa_Controller_Action
{    
    /**
     * Returns json formatted string with information about 
     * the ajax request.
     * 
     * @return void
     */
    public function indexAction()
    {       
        $request = $this->getRequest();
        $url = $this->_getPost('url');
        
        $baseUrlBackup = $this->view->baseUrl();
        
        $this->view->getHelper('baseUrl')->setBaseUrl($this->url());
        
        $baseUrl = $this->view->baseUrl();
        
        $this->view->getHelper('baseUrl')->setBaseUrl($baseUrlBackup);
        
        $url = str_replace($baseUrl, '', $url);
                        
        if ($url[0] == '/') {
            $url = substr($url, 1);
        }
        
        $urlParts = explode('/', $url);
        $newParams = array();
        
        /**
         * Find the module name, controller name and action name
         * from given url.
         */
        if (!empty($urlParts)) {
            $newParams['module'] = $this->getRequest()->getModuleName();
            if (!empty($urlParts[1])) {
                $newParams['controller'] = $urlParts[1];
                if (!empty($urlParts[2])) {
                    $newParams['action'] = $urlParts[2];
                } else {
                    $newParams['action'] = 'index';
                }
            } else {
                $newParams['controller'] = 'index';
                $newParams['action'] = 'index';
            }
        }
                
        if ($newParams['controller'] == 'crud') {
            $newParams['action'] = isset($urlParts[3]) ? $urlParts[3] : 'index';
            $newParams['crudModuleName'] = $urlParts[2];
        }
        
        Zend_Controller_Front::getInstance()->getRequest()
                                            ->clearParams()
                                            ->setParams($newParams);
        
        
        /**
         * Get breadcrumbs.
         */
        $layoutPath = $this->view->layout()->getLayoutPath();
        $this->view->addScriptPath($layoutPath);
        $json['breadcrumbs'] = $this->view->partial('/default/document/main/content/navigation.phtml', 
                                                        array('newParams' => $newParams, 'mixedNavigationArray' => $this->view->mixedNavigationArray));
        
        /**
         * Get page name
         */
        $activePage = $this->view->navigation()->findActive($this->view->mixedNavigation);
        $activePageName = $this->translate((string) $activePage['page']);
        $json['pageName'] = $activePageName;
        /**
         * Get page full title.
         */
        $json['pageTitle'] = strip_tags(
                                 $this->view
                                      ->headTitle($this->translate('Administration'), 'PREPEND')
                                      ->headTitle($this->view->title, 'PREPEND')
                                      ->headTitle($activePageName)
                                      ->toString());
                                  
        $this->_helper->json($json);
    }
}