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
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: CitiesController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for cities administration.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_CitiesController extends Tulipa_Controller_Action
{
    /**
     * Path to the city icons.
     * 
     * @var string
     */
    protected $_iconsPath;
    
    /**
     * Set the icons path.
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_iconsPath = $this->_settings->l10n->iconsPath;
    }
    
    /**
     * Display all avaliable cities.
     * 
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $page = (int) $request->getParam('page');
        
        $citiesModel = Application_Model_L10n::factory('cities');
        
        $form = new Tulipa_Form_L10n;
        
        $this->view->form = $form;
        $paginatorParams = array();
        if ($request->isGet()) {
            if ($form->isValid($request->getParams())) {
                $citiesModel->setOptions($form->getValues());
                $paginatorParams = $form->getValues();
            }
        }
        $cities = $citiesModel->browse();
        
        $paginatorAdapter = new Zend_Paginator_Adapter_Array($cities);
        
        Application_Model_Paginator::create($paginatorAdapter, $page, 'cities', $paginatorParams);
    }
        
    /**
     * Add new city.
     * 
     * @return void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_L10n_Cities;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $citiesModel = Application_Model_L10n::factory('cities', $form->getValues());
                $citiesModel->insert();
                $form->reset();
                $this->status($this->translate('City successfully added'));
            }
        }
        
    }
    
    /**
     * Delete city.
     * 
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        
        $citiesModel = Application_Model_L10n::factory('cities', array('id' => $id));
        $city = $citiesModel->read();
        
        /** City not found **/
        if (!$city) {
            $this->status($this->translate('The city you are trying to delete does not exist'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $citiesModel->delete();
        
        $this->status($this->translate('City successfully deleted'));
        $this->outputStatusJson();
    }
        
    /**
     * Edit city.
     * 
     * @return void
     */
    public function editAction()
    {
        $request = $this->getRequest();
        
        $id = (int) $request->getParam('id');
        
        $citiesModel = Application_Model_L10n::factory('cities', array('id' => $id));
        $lang = $citiesModel->read();
        
        if (!$lang) {
            $this->status($this->translate('City not found'), 'error');
            return;
        }
        
        $form = new Tulipa_Form_L10n_Cities;
        
        $this->view->form = $form;
        $form->formSubmit->setLabel($this->translate("Update"));
        $form->populate($lang);
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $citiesModel->setOptions($form->getValues());
                $citiesModel->update();
                $this->status($this->translate('Country successfully updated'));
            }
        }
        
    }
}