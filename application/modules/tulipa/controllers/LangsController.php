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
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: LangsController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for languages administration.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @see        App_Controller_Default_Abstract
 */
class Tulipa_LangsController extends Tulipa_Controller_Action
{
    /**
     * Path to the language icons.
     * 
     * @var string
     */
    protected $_iconsPath;
    
    /**
     * Path to the language translations.
     * 
     * @var string
     */
    protected $_langsPath;
    
    /**
     * Set the language definitions and icons paths.
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_iconsPath = $this->_settings->langs->iconsPath;
        $this->_langsPath = $this->_settings->langs->path;
    }
    
    /**
     * Display all avaliable languages.
     * 
     * @return void
     */
    public function indexAction()
    { 
        $languagesModel = new Application_Model_Language;        
        $langs = $languagesModel->browse();
        $this->view->languages = $langs;
    }
        
    /**
     * Add new language.
     * 
     * @return void
     */
    public function addAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_Langs;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $languagesModel = new Application_Model_Language($form->getValues());
                $languagesModel->insert();
                $form->reset()->convert->setChecked(true);
                $this->status($this->translate('Successfully added language'));
            }
        }
        
    }
    
    /**
     * Delete action.
     * 
     * Delete action translation.
     * 
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        
        $languagesModel = new Application_Model_Language;
        $lang = $languagesModel->setId($id)->read();
        
        /** Language not found **/
        if (!$lang) {
            $this->status($this->translate('The language you are trying to delete does not exist'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        /** Cannot delete all languages **/
        if (count(Zend_Registry::get('LANGUAGES')) == 1) {
            $this->status($this->translate('You can`t delete all the languages. At least one is required'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        /** The default language can't be deleted **/
        if ($lang['name'] == $this->_settings->lang) {
            $this->status($this->translate('You can not delete the language that is set by default in application/configs/common.ini'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $languagesModel->setOptions(
            array(
                'name' => $lang['name'],
                'icon' => $lang['icon']
            )
        );
        $languagesModel->delete();
        
        $this->status($this->translate('Successful deletion of language'));
        $this->outputStatusJson();
    }
        
    /**
     * Edit language.
     * 
     * @return void
     */
    public function editAction()
    {
        $request = $this->getRequest();
        
        $id = (int) $request->getParam('id');
        
        $languagesModel = new Application_Model_Language;
        $lang = $languagesModel->setId($id)->read();
        
        if (!$lang) {
            $this->status($this->translate('Language not found'), 'error');
            return;
        }
        
        $form = new Tulipa_Form_Langs;
        
        $this->view->form = $form;
        $form->formSubmit->setLabel($this->translate("Edit"));
        $form->populate($lang);
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $languagesModel->setOptions($form->getValues());
                $languagesModel->update();
                $this->status($this->translate('Successful update of language'));
                                
                if (Zend_Registry::isRegistered('Zend_Translate')) {
                    Zend_Translate::clearCache();
                }
            }
        }
        
    }
    
    /**
     * Change language
     * 
     * @return void
     */
    public function changeAction()
    {
        $returnDestination = $_SERVER['HTTP_REFERER'];
        
        $lang = $this->getRequest()->getParam('lang');
        
        if (Application_Model_Language::isValid($lang) & $lang != Application_Model_Language::getSessionLang()->name) {
            Application_Model_Language::changeLanguage($lang);
        }
        
        $this->_redirect($returnDestination);
    }
    
    /**
     * Convert .mo file to php array
     * 
     * @return void
     */
    public function converterAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        $form = new Tulipa_Form_Langs_Converter;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $form->mo->receive();
                $fileName = $form->mo->getFileName(null, true);
                                
                $phpCode = Application_Model_Language_Converter::convert($fileName);
                
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
                
                $response->setHeader('Content-Type', 'application/php')
                         ->setHeader('Content-Disposition', 'attachment; filename=' . basename($fileName, '.mo') 
                                                                                    . '.php')
                         ->appendBody($phpCode);
                         
                $this->_helper->viewRenderer->setNoRender(true);
                $this->_helper->layout->disableLayout();
            }
        }
    }
    
    /**
     * Fetch json translations for JavaScript.
     * 
     * @return void
     */
    public function jsAction()
    {
        $langName = Application_Model_Language::getSessionLang()->name;
        $languagesModel = new Application_Model_Language(array('name' => $langName));
        $lang = $languagesModel->read();
        $jsAdapter = $lang['jsAdapter'];
        
        if ($this->_settings->lang == $langName) {
            $this->_helper->json(array());
            return;
        }
        
        if ($jsAdapter) {
            $file = $this->_settings->langs->path . $langName . '/js.lang';
            if (!file_exists($file)) {
                $this->_helper->json(array());
                return;
            }
            
            $translate = new Zend_Translate($jsAdapter, $file);
            $translations = $translate->getAdapter()->getMessages();                    
            $this->_helper->json($translations);
        } else {
            $this->_helper->json(array());
        }
    }
}