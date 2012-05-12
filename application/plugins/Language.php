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
 * @package    Application_Plugins
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Language.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Configure i18n.
 * 
 * @category   Application
 * @package    Application_Plugins
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
    /**
     * Language name from the settings file.
     * @var string
     */
    protected $_defaultLang;
    
    /**
     * Language name in the session.
     * @var string
     */
    protected $_sessionLang;
    
    /**
     * Get Zend_Cache instance.
     * 
     * Using Core Frontend.
     * 
     * @return Zend_Cache_Core|Zend_Cache_Frontend
     */
    protected function _getCacheInstance()
    {
        $cacheManager = Zend_Registry::get('CACHE_MANAGER');
        $cache = $cacheManager->getCache('commonCache');
                
        return $cache;
    }
    
    /**
     * Configure some common language settings.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {   
        /** Set caching for Zend_Translate **/
        $this->_setCache();
        
        /** Get the default language name from the settings file. **/
        $this->_defaultLang = Zend_Registry::get('COMMON_SETTINGS')->lang;        
        
        /** Get the session language name **/
        $this->_sessionLang = Application_Model_Language::getSessionLang()->name;  
        
        /**
         * Get all lnguages and register them
         * in Zend_Registry.
         */        
        $cache = $this->_getCacheInstance();
        
        $cacheId = 'languages';
        if (!($langs = $cache->load($cacheId))) {
            $langModel = Application_Model_Language::getInstance()->clearOptions();
            $langs = $langModel->browse();
            $cache->save($langs, $cacheId, array(__CLASS__ . '_Cache'));
        }
        
        Zend_Registry::set('LANGUAGES', $langs);
        
        $requestLang = $request->getParam('lang');
        
        
        if ($request->getModuleName() !== 'tulipa') {
            
            if (!empty($requestLang) && $requestLang != $this->_sessionLang) {
                Application_Model_Language::changeLanguage($requestLang);
                $this->_sessionLang = $requestLang;
            } else if (empty($requestLang)) {
                /*
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');            
                $redirector->gotoRouteAndExit(array(
                        'lang' => $this->_sessionLang,
                    ), 'default', true
                );
                */
            }
            
//            $router = Zend_Controller_Front::getInstance()->getRouter();
//            $router->setGlobalParam('lang', $this->_sessionLang);
        
        }
                               
        Zend_Registry::set('Zend_Locale', new Zend_Locale($this->_sessionLang));
        
        if (!Zend_Registry::isRegistered('LANGUAGE_ID')) {
            Zend_Registry::set('LANGUAGE_ID', Application_Model_Language::getSessionLang()->id);
        }
                
        /** Check for errors **/
        //$this->_errorCheck();
        /** Set translation file for the php source code **/
        $this->_setPhpTranslation();
        /** Set translation file for the Zend_Validate **/
        $this->_setZendValidateTranslation();
        /** Set translation file for the Zend_Measure **/
        $this->_setZendMeasureTranslation();
    }
    
    /**
     * Check for translation errors.
     * 
     * Checks is the settings language exists in the db table.
     * 
     * @return void
     */
    protected function _errorCheck()
    {
        $defaultLang = $this->_defaultLang;
        
        $langModel = Application_Model_Language::getInstance()->clearOptions();
        $defaultLangCheck = $langModel->setName($defaultLang)
                                      ->read();
        if (!$defaultLangCheck) {
            trigger_error('The language pointed in the configuration file must exist in the 
            database table for languages! Here are the avaliable languages:');
            var_dump($langModel->browse());
            exit;
        }
    }
    
    /**
     * Set caching for Zend_Translate
     * 
     * @return void
     */
    protected function _setCache()
    {
        $frontendOptions = array(
            'caching' => true,
            'automatic_serialization' => true
        );
        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/../cache/'
        );
        
        $cache = Zend_Cache::factory('Core',
                             'File',
                             $frontendOptions,
                             $backendOptions);
           
        Zend_Translate::setCache($cache);
    }
    
    /**
     * Set translation file for the php source code.
     * 
     * @return void
     */
    protected function _setPhpTranslation()
    {
        $phpAdapter = Application_Model_Language::getSessionLang()->phpAdapter;
        $defaultLang = $this->_defaultLang;
        $sessionLang = $this->_sessionLang;
        
        $commonSettings = Zend_Registry::get('COMMON_SETTINGS');
        
        /** Load gettext/array translation **/
        if (!empty($phpAdapter)) {
            $translate = @new Zend_Translate($phpAdapter, $commonSettings->langs->path . $sessionLang 
                                                                                       . '/php.lang', 
                                                        $sessionLang);
            
            Zend_Registry::set('Zend_Translate', $translate);
        }
    }
    
    /**
     * Set translation file for Zend_Validate.
     * 
     * @return void
     */
    protected function _setZendValidateTranslation()
    {        
        $sessionLang = $this->_sessionLang;
        
        $commonSettings = Zend_Registry::get('COMMON_SETTINGS');
        
        $zendValidateTranslationFile = $commonSettings->langs->path . $sessionLang . '/Zend_Validate.php';
        
        if (file_exists($zendValidateTranslationFile)) {
                        
            $vTranslator = new Zend_Translate(
              'array',
              $zendValidateTranslationFile,
              $sessionLang
            );
            
            Zend_Validate_Abstract::setDefaultTranslator($vTranslator);
            Zend_Form::setDefaultTranslator($vTranslator);
        }
        
    }
    
    /**
     * Set translation file for Zend_Measure.
     * 
     * @return void
     */
    protected function _setZendMeasureTranslation()
    {        
        $sessionLang = $this->_sessionLang;
        
        $commonSettings = Zend_Registry::get('COMMON_SETTINGS');
        
        $zendMeasureTranslationFile = $commonSettings->langs->path . $sessionLang . '/Zend_Measure.php';
        
        if (file_exists($zendMeasureTranslationFile)) {            
            if (Zend_Registry::isRegistered('Zend_Translate')) {
                $vTranslator = Zend_Registry::get('Zend_Translate');
                $vTranslator->addTranslation($zendMeasureTranslationFile, $sessionLang);
            } else {
                $vTranslator = new Zend_Translate('array', $zendMeasureTranslationFile, $sessionLang);
                $vTranslator->setLocale($sessionLang);
                $vTranslator = Zend_Registry::set('Zend_Translate', $vTranslator);
            }
        }
        
    }
}
