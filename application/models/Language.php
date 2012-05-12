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
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Language.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Language model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Language extends Application_Model_Abstract
                                 implements Application_Bread_Interface
{
	/**
	 * @var int
	 */
 	protected $_id;
	 
	/**
     * Language name.
	 * @var string
	 */
 	protected $_title;
	 
	/**
     * Language short name.
	 * @var string
	 */
 	protected $_name;
    
    /**
     * Language icon.
     * @var string
     */
    protected $_icon;
    
    /**
     * Php translation file.
     * @var string
     */
    protected $_entirePhp;
    
    /**
     * JavaScript translation file.
     * @var string
     */
    protected $_entireJs;
    
    /**
     * Convert automaticly *.mo to php array
     * @var boolean
     */
    protected $_convert;
    
    /**
     * Php translation adapter.
     * @var string
     */
    protected $_phpAdapter;
    
    /**
     * JavaScript translation adapter.
     * @var string
     */
    protected $_jsAdapter;
        
    /**
     * Set Application_Model_Language::$_id
     * 
     * @param int $id
     * @return Application_Model_Language
     */
    public function setId($id = null)
    {
        if (null === $id) {
            $this->_id = null;
            return $this;
        }
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Application_Model_Language::$_title
     * 
     * @param string $title
     * @return Application_Model_Language
     */
    public function setTitle($title = null)
    {
        if (null === $title) {
            $this->_title = null;
            return $this;
        }
        $this->_title = (string) $title;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_title
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Set Application_Model_Language::$_name
     * 
     * @param string $name
     * @return Application_Model_Language
     */
    public function setName($name = null)
    {
        if (null === $name) {
            $this->_name = null;
            return $this;
        }
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set Application_Model_Language::$_icon
     * 
     * @param string $icon
     * @return Application_Model_Language
     */
    public function setIcon($icon = null)
    {
        if (null === $icon) {
            $this->_icon = null;
            return $this;
        }
        $this->_icon = (string) $icon;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_icon
     * 
     * @return string
     */
    public function getIcon()
    {
        return $this->_icon;
    }

    /**
     * Set Application_Model_Language::$_entirePhp
     * 
     * @param string $entirePhp
     * @return Application_Model_Language
     */
    public function setEntirePhp($entirePhp = null)
    {
        if (null === $entirePhp) {
            $this->_entirePhp = null;
            return $this;
        }
        $this->_entirePhp = (string) $entirePhp;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_entirePhp
     * 
     * @return string
     */
    public function getEntirePhp()
    {
        return $this->_entirePhp;
    }

    /**
     * Set Application_Model_Language::$_entireJs
     * 
     * @param string $entireJs
     * @return Application_Model_Language
     */
    public function setEntireJs($entireJs = null)
    {
        if (null === $entireJs) {
            $this->_entireJs = null;
            return $this;
        }
        $this->_entireJs = (string) $entireJs;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_entireJs
     * 
     * @return string
     */
    public function getEntireJs()
    {
        return $this->_entireJs;
    }

    /**
     * Set Application_Model_Language::$_convert
     * 
     * @param boolean $convert
     * @return Application_Model_Language
     */
    public function setConvert($convert = null)
    {
        if (null === $convert) {
            $this->_convert = null;
            return $this;
        }
        $this->_convert = (boolean) $convert;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_convert
     * 
     * @return boolean
     */
    public function getConvert()
    {
        return $this->_convert;
    }

    /**
     * Set Application_Model_Language::$_phpAdapter
     * 
     * @param string $phpAdapter
     * @return Application_Model_Language
     */
    public function setPhpAdapter($phpAdapter = null)
    {
        if (null === $phpAdapter) {
            $this->_phpAdapter = null;
            return $this;
        }
        $this->_phpAdapter = (string) $phpAdapter;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_phpAdapter
     * 
     * @return string
     */
    public function getPhpAdapter()
    {
        return $this->_phpAdapter;
    }

    /**
     * Set Application_Model_Language::$_jsAdapter
     * 
     * @param string $jsAdapter
     * @return Application_Model_Language
     */
    public function setJsAdapter($jsAdapter = null)
    {
        if (null === $jsAdapter) {
            $this->_jsAdapter = null;
            return $this;
        }
        $this->_jsAdapter = (string) $jsAdapter;
        return $this;
    }

    /**
     * Get Application_Model_Language::$_jsAdapter
     * 
     * @return string
     */
    public function getJsAdapter()
    {
        return $this->_jsAdapter;
    }
    
    /**
     * Process translation files.
     * 
     * Convert files if it's needed.
     * 
     * @param string $fileName
     * @param string $type
     * @return array
     */
    protected function _processTranslationFile($fileName, $type)
    {
        $path = $this->_commonSettings->tempPath . '/langs/entire/' . $type;
        $langsPath = $this->_commonSettings->langs->path . $this->getName() . '/';
        /** Create new directory for the new language **/
        if (!file_exists($langsPath))
            mkdir($langsPath);
        
        /** Temp file full path **/
        $fullPath = $path . '/' . $fileName;
        /** Get temp file information **/
        $fileInfo = pathinfo($fullPath);
        /** The new file name **/
        $newFile = $type . '.lang';
        /** Cleanup if the same file exists **/
        @unlink($langsPath . $newFile);
        
        /** First stage - check is setted to be coverted **/
        if ($this->getConvert() & $fileInfo['extension'] == 'mo') {    
            
            /** Only now we can convert **/
            $phpCode = Application_Model_Language_Converter::convert($fullPath);
            
            $fh = fopen($langsPath . $newFile, 'w');
            fwrite($fh, $phpCode);
            fclose($fh);
            
            /** Adapter is array **/
            $adapter = 'array';
        } else {
            copy($fullPath, $langsPath . $newFile);
            if ($fileInfo['extension'] == 'mo') 
                $adapter = 'gettext';
            else
                $adapter = 'array';
        }
        
        return $adapter;
    }

    /**
     * Add new language.
     * 
     * @return Application_Model_Language
     */
    public function insert()
    {
        $this->_createTranslations();        
        $id = $this->getMapper()->insert($this);
        $this->setId($id);
        return $this;
    }

    /**
     * Delete language.
     * 
     * @return Application_Model_Language
     */
    public function delete()
    {        
        $settings = $this->_commonSettings; 
        
        $name = $this->getName();
        
        if (empty($name)) {
            $this->read();
            $name = $this->getName();
        }
        
        $icon = $this->getIcon();
        if (!empty($icon)) {
            $iconsPath = $this->_commonSettings->langs->iconsPath;
            if (file_exists($iconsPath . $icon)) {
                unlink($iconsPath . $icon);
            }
        }
        
        $sessionLang = self::getSessionLang()->name;
        
        if ($name == $sessionLang) {
            self::setSessionLang($settings->lang);
        }
        
        $this->getMapper()->delete($this);
        return $this;
    }

    /**
     * Update language.
     * 
     * @return Application_Model_Language
     */
    public function update()
    {
        $this->_createTranslations();        
        $this->getMapper()->update($this);
        return $this;
    }
    
    /**
     * Create the translations variable.
     * 
     * @return void
     */
    protected function _createTranslations()
    {
        $entirePhp = $this->getEntirePhp();
        $entireJs = $this->getEntireJs();
        
        $translations = null;
        
        $basicLangsPath = $this->_commonSettings->langs->path . $this->getName() . '/';
        
        if (!file_exists($basicLangsPath)) {
            mkdir($basicLangsPath);
        }        
        
        if (!empty($entirePhp)) {
            $this->setPhpAdapter($this->_processTranslationFile($entirePhp, 'php'));
        }
        
        if (!empty($entireJs)) {
            $this->setJsAdapter($this->_processTranslationFile($entireJs, 'js'));
        }
    }
    
    /**
     * Browse all available languages. 
     * 
     * @param $returnArray If it's true - return result as array,
	 *                     if it's false - return Zend_Db_Select instance 
	 *                     (frequently used for Zend_Paginator).
	 * @return null|array|Zend_Db_Select
     */
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse($this, true);
    }
    
    /**
     * Read language by id.
     * 
     * @return array
     */
    public function read()
    {
        $row = $this->getMapper()->read($this);
        $this->setOptions($row);
        return $row;
    }
    
    /**
     * Get one language by language id (static).
     * 
     * Proxies to {@link read()}.
     * 
     * @param int $languageId
     * @return array
     */
    static public function readById($languageId)
    {
        return self::getInstance()->setId($languageId)->read();
    }
    
    /**
     * Check is $langName existing in the languages array.
     * 
     * @param string $lang
     * @return boolean
     */
    static public function isValid($langName)
    {
        $langs = Zend_Registry::get('LANGUAGES');
        
        foreach ($langs as $lang)
        {
            if ($lang['name'] == $langName) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get session language
     * 
     * @param string $name
     * @return Zend_Session_Namespace
     */
    public static function getSessionLang()
    {
        $settings = Zend_Registry::get('COMMON_SETTINGS');
        
        if (defined('CLI_MODE') || defined('STDIN')) {
            $model = self::getInstance()->clearOptions();
            $langOptions = $model->setName($settings->lang)->read();
            
            $languageSession = new stdClass;
            
            $languageSession->id = $langOptions['id'];
            $languageSession->title = $langOptions['title'];
            $languageSession->name = $langOptions['name'];
            $languageSession->icon = $langOptions['icon'];
            $languageSession->jsAdapter = $langOptions['jsAdapter'];
            $languageSession->phpAdapter = $langOptions['phpAdapter'];
            
            Zend_Registry::set('LANGUAGE_ID', $langOptions['id']);
            
            return $languageSession;
        }
        
        $languageSession = new Zend_Session_Namespace('language');
                
        if (!isset($languageSession->id)) {
            return self::setSessionLang($settings->lang);
        }
        
        return $languageSession;
    }
    
    /**
     * Change current language.
     * 
     * @param string $langName
     * @return void
     */
    public static function changeLanguage($langName)
    {
        $language = Zend_Filter::filterStatic($langName, 'alnum');
        
        if (!self::isValid($language)) {
            return;
        }
        
        if (Application_Model_Language::isValid($language) & $language != Application_Model_Language::getSessionLang()->name) {
            Application_Model_Language::setSessionLang($language);
            $cacheManager = Zend_Registry::get('CACHE_MANAGER');
            $cache = $cacheManager->getCache('unserializedCache');
            $cache->clean();
            // clear page cache
            //Zend_Registry::get('PAGE_CACHE')->clean();
            Zend_Translate::clearCache();
        }
    }
    
    /**
     * Set new session lang.
     * 
     * @param string $lang
     * @return Zend_Session_Namespace
     */
    public static function setSessionLang($langName)
    {        
        $languageSession = new Zend_Session_Namespace('language');
        
        $model = self::getInstance()->clearOptions();
        $langOptions = $model->setName($langName)->read();
        
        $languageSession->id = $langOptions['id'];
        $languageSession->title = $langOptions['title'];
        $languageSession->name = $langOptions['name'];
        $languageSession->icon = $langOptions['icon'];
        $languageSession->jsAdapter = $langOptions['jsAdapter'];
        $languageSession->phpAdapter = $langOptions['phpAdapter'];
                
        /** Set language id in the registry **/
        Zend_Registry::set('LANGUAGE_ID', $langOptions['id']);
        
        return $languageSession;
    }
    
    /**
     * Renew php translation file.
     * 
     * @return void
     */
    public static function refreshPhpTranslation()
    {        
        $currentLanguage = self::getSessionLang();
        $phpAdapter = $currentLanguage->phpAdapter;
        $langName = $currentLanguage->name;
        
        $translationFile = Zend_Registry::get('COMMON_SETTINGS')->langs->path . $langName . '/php.lang';
        if (file_exists($translationFile) & !empty($phpAdapter)) {
            $translate = @new Zend_Translate($phpAdapter, $translationFile, $langName);
            
            Zend_Registry::set('Zend_Translate', $translate);
        }
    }
    
}