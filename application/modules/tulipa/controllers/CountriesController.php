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
 * @version    $Id: CountriesController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for countries administration.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_CountriesController extends Tulipa_Controller_Action
{
    /**
     * Path to the country icons.
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
     * Display all avaliable countries.
     * 
     * @return void
     */
    public function indexAction()
    {
        $page = (int) $this->getRequest()->getParam('page');
        
        $countriesModel = Application_Model_L10n::factory('countries');
        
        $countries = $countriesModel->browse();
        
        $paginatorAdapter = new Zend_Paginator_Adapter_Array($countries);
        
        Application_Model_Paginator::create($paginatorAdapter, $page, 'countries');
    }
        
    /**
     * Add new country.
     * 
     * @return void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_L10n_Countries;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $countriesModel = Application_Model_L10n::factory('countries', $form->getValues());
                $countriesModel->insert();
                $form->reset();
                $this->status($this->translate('Country successfully added'));
            }
        }
        
    }
    
    /**
     * Delete country.
     * 
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        
        $countriesModel = Application_Model_L10n::factory('countries', array('id' => $id));
        $country = $countriesModel->read();
        
        /** Country not found **/
        if (!$country) {
            $this->status($this->translate('Country that you are trying to delete does not exist'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $countriesModel->delete();
        
        $this->status($this->translate('Country successfully deleted'));
        $this->outputStatusJson();
    }
        
    /**
     * Edit country.
     * 
     * @return void
     */
    public function editAction()
    {
        $request = $this->getRequest();
        
        $id = (int) $request->getParam('id');
        
        $countriesModel = Application_Model_L10n::factory('countries', array('id' => $id));
        $lang = $countriesModel->read();
        
        if (!$lang) {
            $this->status($this->translate('Country not found'), 'error');
            return;
        }
        
        $form = new Tulipa_Form_L10n_Countries;
        
        $this->view->form = $form;
        $form->formSubmit->setLabel($this->translate("Update"));
        $form->populate($lang);
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $countriesModel->setOptions($form->getValues());
                $countriesModel->update();
                $this->status($this->translate('Country successfully updated'));
            }
        }
        
    }
}