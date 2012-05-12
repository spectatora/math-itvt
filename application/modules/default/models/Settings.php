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
 * @category   Default
 * @package    Default_Models
 * @subpackage Settings
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Settings.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Common website settings (such as SEO) settings model.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage Settings
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_Settings extends Default_Model_Abstract
                             implements Application_Bread_Interface
{
	
	/** Avaliable settings **/
	const SETTING_SEO_DESCRIPTION = 'seoDescription';
	const SETTING_SEO_KEYWORDS = 'seoKeywords';
	const SETTING_SEO_ROBOTS = 'seoRobots';
	
    /**
     * @var string
     */
    protected $_name = null;

    /**
     * @var string
     */
    protected $_content = null;
    
    /**
     * @var array
     */
    protected $_settings = array(
        self::SETTING_SEO_DESCRIPTION, self::SETTING_SEO_KEYWORDS,
        self::SETTING_SEO_ROBOTS
    );
    
    /**
     * Set Default_Model_Settings::$_name
     * 
     * @param string $name
     * @return Default_Model_Settings
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
     * Get Default_Model_Settings::$_name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set Default_Model_Settings::$_content
     * 
     * @param string $content
     * @return Default_Model_Settings
     */
    public function setContent($content = null)
    {
        if (null === $content) {
            $this->_content = null;
            return $this;
        }
        $this->_content = (string) $content;
        return $this;
    }

    /**
     * Get Default_Model_Settings::$_content
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Set Default_Model_Settings::$_settings
     * 
     * @param array $settings
     * @return Default_Model_Settings
     */
    public function setSettings($settings = null)
    {
        if (null === $settings) {
            $this->_settings = null;
            return $this;
        }
        $this->_settings = (array) $settings;
        return $this;
    }

    /**
     * Get Default_Model_Settings::$_settings
     * 
     * @return array
     */
    public function getSettings()
    {
        return $this->_settings;
    }
    
    public function browse($returnArray = false)
    {
    	return $this->getMapper()
    	            ->browse($this, $returnArray);
    }
    
    /**
     * Browse all settings and extract them into
     * array, ready for form usage.
     * 
     * @return array
     */
    public function browseReadyForForm()
    {
    	$settings = $this->browse(true);
    	$readySettings = array();
    	
    	foreach ($settings as $setting)
    	{
    	   	$readySettings[$setting['name']] = $setting['content'];
    	}
    	
    	return $readySettings;
    }
    
    /**
     * Read settings row by setting name.
     * 
     * @return array|null
     */
    public function read()
    {
    	$row = $this->getMapper()
    	            ->read($this);
    	$this->setOptions($row);
    	return $row;
    }
    
    public function update()
    {
    	$this->getMapper()
             ->update($this);
    	return $this;
    }
    
    /**
     * Insert method is not avaliable for this model.
     * 
     * @throws Zend_Exception
     */
    public function insert()
    {
        throw new Zend_Exception('Insert method is not avaliable for this model');    	
    }
    
    /**
     * Delete method is not avaliable for this model.
     * 
     * @throws Zend_Exception
     */
    public function delete()
    {
    	throw new Zend_Exception('Delete method is not avaliable for this model');
    }
    
    /**
     * Read field by setting name.
     * 
     * @param $fieldName
     * @param $name
     * @return string|null
     */
    public static function readFieldByName($fieldName = null, $name = null)
    {
        if (empty($name) or empty($fieldName)) {
            return;
        }
        
        $cacheManager = Zend_Registry::get('CACHE_MANAGER');
        $cache = $cacheManager->getCache('commonCache');
        
        $cacheId = 'settingsField' . ucfirst($fieldName) . 'ByName' . ucfirst($name);
        
        if (!($fieldByName = $cache->load($cacheId))) {
            
            $model = self::getInstance();
        
            $fieldByName = $model->setName($name)
                                 ->getMapper()
                                 ->readOne($model, $fieldName);
            
            $cache->save($fieldByName, $cacheId, array('settings'));
        }
        
        return $fieldByName;
    }
}