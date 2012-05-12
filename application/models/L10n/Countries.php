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
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Countries.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Localization/Countries model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_L10n_Countries extends Application_Model_L10n_Abstract
{
    /**
     * @var int
     */
    protected $_id = null;

    /**
     * @var string
     */
    protected $_name = null;

    /**
     * @var string
     */
    protected $_icon = null;

    /**
     * @var string
     */
    protected $_code = null;

    /**
     * @var int
     */
    protected $_langId = null;

    /**
     * @var boolean
     */
    protected $_default = null;

    /**
     * Set Application_Model_L10n_Countries::$_id
     * 
     * @param int $id
     * @return Application_Model_L10n_Countries
     */
    public function setId($id = null)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Countries::$_id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Application_Model_L10n_Countries::$_name
     * 
     * @param string $name
     * @return Application_Model_L10n_Countries
     */
    public function setName($name = null)
    {
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Countries::$_name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set Application_Model_L10n_Countries::$_icon
     * 
     * @param string $icon
     * @return Application_Model_L10n_Countries
     */
    public function setIcon($icon = null)
    {
        $this->_icon = (string) $icon;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Countries::$_icon
     * 
     * @return string
     */
    public function getIcon()
    {
        return $this->_icon;
    }

    /**
     * Set Application_Model_L10n_Countries::$_code
     * 
     * @param string $code
     * @return Application_Model_L10n_Countries
     */
    public function setCode($code = null)
    {
        $this->_code = (string) $code;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Countries::$_code
     * 
     * @return string
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Set Application_Model_L10n_Countries::$_langId
     * 
     * @param int $langId
     * @return Application_Model_L10n_Countries
     */
    public function setLangId($langId = null)
    {
        $this->_langId = empty($langId) ? null : (int) $langId;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Countries::$_langId
     * 
     * @return int
     */
    public function getLangId()
    {
        return $this->_langId;
    }

    /**
     * Set Application_Model_L10n_Countries::$_default
     * 
     * @param boolean $default
     * @return Application_Model_L10n_Countries
     */
    public function setDefault($default = null)
    {
        $this->_default = (boolean) $default;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Countries::$_default
     * 
     * @return boolean
     */
    public function getDefault()
    {
        return $this->_default;
    }
    
    /**
     * Add new country to the DB Table.
     * 
     * @return Application_Model_L10n_Countries
     */
    public function insert()
    {
        $id = $this->getMapper()->insert($this);
        $this->setId($id);
        return $this;
    }
    
    /**
     * Check if country exists.
     * 
     * @param int $countryId If null, it's used model's $_id.
     * @return boolean
     */
    public function checkExistence($countryId = null)
    {
        if (null !== $countryId) {
            $this->setId($countryId);
        }
        $record = $this->getMapper()->read($this);
        if (empty($record)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Browse all countries.
     * 
     * @return array|null
     */
    public function browse()
    {
        return $this->getMapper()->browse($this);
    }
    
    /**
     * Read one country by ID.
     * 
     * @return array|null
     */
    public function read()
    {
        return $this->getMapper()->read($this);
    }
    
    /**
     * Update one country by ID.
     * 
     * @return array|null
     */
    public function update()
    {
        return $this->getMapper()->update($this);
    }
    
    /**
     * Delete one country by ID.
     * 
     * @return array|null
     */
    public function delete()
    {
        return $this->getMapper()->delete($this);
    }
}