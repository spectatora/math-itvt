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
 * @subpackage Roles
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: RolesController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * ACL Roles controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Roles
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_RolesController extends Tulipa_Controller_Action
{
    /**
     * Display all avaliable roles.
     * 
     * @return void
     */
    public function indexAction()
    {
        $roles = Application_Model_Acl::browseRoles();
        
        $this->view->roles = $roles;
    }
    
    /**
     * Add new ACL Role
     * 
     * @return void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_Acl_Roles;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $rolesModel = Application_Model_Acl::factory('roles')
                                               ->setOptions($form->getValues());                
                $rolesModel->insert();
                $this->status($this->translate('Role successfully added'));
                $form->reset();
            }            
        }
    }
    
    /**
     * Edit Acl Role
     * 
     * @return void
     */
    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int) $request->getParam('id');
        
        $rolesModel = Application_Model_Acl::factory('roles')->setId($id);
        
        $role = $rolesModel->read();
        
        /**
         * Check for existance.
         */
        if (empty($role)) {
            $this->status($this->translate('Role not found'), 'error', true);
            return;
        }
        
        $form = new Tulipa_Form_Acl_Roles;
        
        $form->formSubmit->setLabel($this->translate('Update'));
        $form->populate($role);
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $rolesModel->setOptions($form->getValues())
                           ->update();
                $this->status($this->translate('Role successfully updated'));
            }            
        }
    }
    
    /**
     * Delete Acl Role
     * 
     * @return void
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $id = (int) $request->getParam('id');
        
        $rolesModel = Application_Model_Acl::factory('roles')->setId($id);
        
        $role = $rolesModel->read();
        
        /**
         * Check for existance.
         */
        if (empty($role)) {
            $this->status($this->translate('Role not found'), 'error', true);
            $this->outputStatusJson();
            return;
        }
                
        /**
         * Check if the role is a default one.
         */
        $defaultRole = Application_Model_Acl::readRoleByDefault(Application_Model_Acl_Adapter_Roles::DEFAULT_GUEST);
        
        if ($role['id'] == $defaultRole['id']) {
            $this->status($this->translate('You can not delete a role that is selected by default'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $rolesModel->delete();
        
        $this->status($this->translate('Role successfully deleted'));
        $this->outputStatusJson();
    }
}