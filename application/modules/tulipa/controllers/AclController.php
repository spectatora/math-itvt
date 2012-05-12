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
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: AclController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * ACL controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_AclController extends Tulipa_Controller_Action
{
    /**
     * Display all avaliable Acl rules.
     * 
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $page = $request->getParam('page');
        
        Zend_Registry::get('Zend_Acl_Cache')->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('Zend_Acl'));
        
        Application_Model_Acl::compare();
        
        $acl = Application_Model_Acl::browseAcl();
        
        $paginationAdapter = new Zend_Paginator_Adapter_Array($acl);
        
        Application_Model_Paginator::create($paginationAdapter, $page, 'acl');
    }
    
    /**
     * Add new Acl Rule.
     * 
     * @return void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_Acl;
        
        $this->view->form = $form;
        $this->_loadFormInfo();
        
        if ($request->isPost()) {

            if ($form->isValid($request->getPost())) {
                
                $resourceName = $form->getValue('module') . Application_Model_Acl::HIERARCHY_SEPARATOR . $form->getValue('resource');
                $resource = Application_Model_Acl::factory('resources')
                                                 ->setName($resourceName)
                                                 ->read();
                /**
                 * Resource check.
                 */                                             
                if (empty($resource)) {
                    $form->addError($this->translate('Resource not found'));
                    return;
                }
                
                $privilege = Application_Model_Acl::factory('privileges')
                                                  ->setResourceId($resource['id'])
                                                  ->setName($form->getValue('privilege'))
                                                  ->read();
                /**
                 * Privilege check.
                 */
                if (empty($privilege) & $form->getValue('privilege') != null) {
                    $form->addError($this->translate('Privilege not found'));
                    return;
                }
                
                $data = array(
                    'resourceId' => $resource['id'],
                    'privilegeId' => empty($privilege) ? null : $privilege['id'],
                    'roleId' => $form->getValue('roleId'),
                    'allow' => (boolean) $form->getValue('allow')
                );
                
                $accessModel = Application_Model_Acl::factory('access')
                                                    ->setOptions($data);
                
                $accessModel->insert();
                $this->status($this->translate('Access rules successfully added'));
                $form->reset();
            }
        }
        
    }
    
    /**
     * Delete Acl Rule
     * 
     * @return void
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = (int) $request->getParam('id');
        
        $rulesModel = Application_Model_Acl::factory('access')->setId($id);
        
        $rule = $rulesModel->read();
        
        /**
         * Check for existance.
         */
        if (empty($rule)) {
            $this->status($this->translate('Access rules not found'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $rulesModel->delete();
        
        $this->status($this->translate('Access rules successfully deleted'));
        $this->outputStatusJson();
    }
    
    /**
     * Loads the controllers and actions 
     * array into the view.
     * 
     * @return void
     */
    protected function _loadFormInfo()
    {
        $modules = Application_Model_Acl_Scanner::scanModules();
        $actionsArray = array();
        $controllersArray = array();
        
        if (!empty($modules)) {
            foreach ($modules as $module)
            {
                $controllers = Application_Model_Acl_Scanner::scanControllers($module);
                if (!empty($controllers)) {
                    foreach ($controllers as $controller => $actions)
                    {
                        $controllersArray[$module][] = $controller;
                        $actionsArray[$module][$controller] = $actions;
                    }
                }
            }
        }
        
        $this->view->controllers = $controllersArray;
        $this->view->actions = $actionsArray;
    }
    
}