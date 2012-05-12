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
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: UsersController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for users administration.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_UsersController extends Tulipa_Controller_Action
{    
    /**
     * Display all avaliable cities.
     * 
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $page = (int) $request->getParam('page');
        
        $usersSearchModel = new Application_Model_Users_Search;
    
        $form = new Tulipa_Form_Users_Search;
        
        $this->view->form = $form;
        $paginatorParams = array();
        if ($request->isGet()) {
            if ($form->isValid($request->getParams())) {
                $usersSearchModel->setOptions($form->getValues());
                $paginatorParams = $form->getValues();
            }
        }
        
        $users = $usersSearchModel->search(false);
                        
        $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($users);
        
        Application_Model_Paginator::create($paginatorAdapter, $page, 'users', $paginatorParams);
    }
    
    /**
     * Delete user.
     * 
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        
        $usersModel = new Application_Model_Users(array('id' => $id));
        $user = $usersModel->read(array('id'));
                
        /** User not found **/
        if (empty($user)) {
            $this->status($this->translate('The user who you are trying to delete does not exist'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $usersModel->delete();
        
        $this->status($this->translate('User successfully deleted'));
        $this->outputStatusJson();
    }
    
    /**
     * Edit user.
     * 
     * @return void
     */
    public function editAction()
    {
        $request = $this->getRequest();
        
        $id = (int) $this->getRequest()->getParam('id');
        
        $usersModel = new Application_Model_Users(array('id' => $id));
        $user = $usersModel->read(array('id'));
        
        if (empty($user)) {
            $this->status($this->translate('The user who you are trying to update does not exist'), 'error');
            return;
        }
        
        $form = new Tulipa_Form_Users_Edit;
        
        $form->cityId->setMultiOptions($form->getCitiesMultiSelect((int) $usersModel->getCountryId()));
        $this->view->form = $form;
        $form->formSubmit->setLabel($this->translate("Update"));
        $form->populate($user);
        
        if ($request->isPost()) {
            $form->getElement('cityId')
                 ->setMultiOptions($form->getCitiesMultiSelect((int) $request->getPost('countryId')));  
            if ($form->isValid($request->getPost())) {
                $usersModel->setOptions($form->getValues());
                $usersModel->update();
                $this->status($this->translate('User successfully edited'));
            }
        }
        
    }
    
    /**
     * Add new user
     * 
     * @return void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_Users_Add;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {            
            $form->getElement('cityId')
                 ->setMultiOptions($form->getCitiesMultiSelect((int) $request->getPost('countryId')));                 
            if ($form->isValid($request->getPost())) {
                $usersModel = new Application_Model_Users($form->getValues());
                $usersModel->insert();
                if ($usersModel->hasErrors()) {
                    $this->getHelper('Status')->addErrors($usersModel->getErrors());
                    return;
                } else {
                    $this->status($this->translate('User successfully created'));
                    $form->reset();
                }
            }
        }
    }
    
    /**
     * Get cities multiselect options for 
     * the given country id.
     * 
     * @return void
     */
    public function getCitiesAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $countryId = (int) $request->getParam('country');
        
        $form = new Tulipa_Form_Users_Add;
                        
        if (Application_Model_L10n::factory('countries', array('id' => $countryId))->checkExistence()) {
            $form->getElement('cityId')
                 ->setMultiOptions($form->getCitiesMultiSelect($countryId));
        }
        
        $htmlTag = $form->getElement('cityId')
                        ->clearDecorators()
                        ->addDecorator('ViewHelper');
                        
        $response->setBody($htmlTag->render());
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
    }
}