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
 * @version    $Id: Cities.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */
 
/**
 * Localization/Cities model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_L10n_Cities extends Application_Model_L10n_Abstract
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
     * @var int
     */
    protected $_countryId = null;

    /**
     * Set Application_Model_L10n_Cities::$_id
     * 
     * @param int $id
     * @return Application_Model_L10n_Cities
     */
    public function setId($id = null)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Cities::$_id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Application_Model_L10n_Cities::$_name
     * 
     * @param string $name
     * @return Application_Model_L10n_Cities
     */
    public function setName($name = null)
    {
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Cities::$_name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set Application_Model_L10n_Cities::$_countryId
     * 
     * @param int $countryId
     * @return Application_Model_L10n_Cities
     */
    public function setCountryId($countryId = null)
    {
        $this->_countryId = (int) $countryId;
        return $this;
    }

    /**
     * Get Application_Model_L10n_Cities::$_countryId
     * 
     * @return int
     */
    public function getCountryId()
    {
        return $this->_countryId;
    }
    
    /**
     * Add new city to the DB Table.
     * 
     * @return Application_Model_L10n_Cities
     */
    public function insert()
    {
        $id = $this->getMapper()->insert($this);
        $this->setId($id);
        return $this;
    }
    
    /**
     * Browse all cities.
     * 
     * @return array|null
     */
    public function browse()
    {
        return $this->getMapper()->browse($this);
    }
    
    /**
     * Read one city by ID.
     * 
     * @return array|null
     */
    public function read()
    {
        return $this->getMapper()->read($this);
    }
    
    /**
     * Update one city by ID.
     * 
     * @return array|null
     */
    public function update()
    {
        return $this->getMapper()->update($this);
    }
    
    /**
     * Delete one city by ID.
     * 
     * @return array|null
     */
    public function delete()
    {
        return $this->getMapper()->delete($this);
    }
}