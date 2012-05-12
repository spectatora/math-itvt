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
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Roles.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Acl Roles Model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl_Adapter_Roles extends Application_Model_Acl_Adapter_Abstract
                                          implements Application_Bread_Interface
{    
    const DEFAULT_GUEST = 'guest';
    const DEFAULT_STANDART = 'standart';
    const DEFAULT_SUPER = 'super';
    
    /**
     * Role id.
     * @var int
     */
    protected $_id = null;
    
    /**
     * Code name.
     * @var string
     */
    protected $_name = null;
    
    /**
     * Role parent.
     * @var int Existing Acl Role id.
     */
    protected $_parentId = null;
    
    /**
     * @var string
     */
    protected $_default = false;
    
    /**
     * Translation on avaliable languages.
     * @var array
     */
    protected $_translations = null;
    
    /**
     * Set Acl Role Id
     * 
     * @param int $id
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setId($id = null)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    /**
     * Get Acl Role Id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setName($name = null)
    {
        $this->_name = (string) $name;
        return $this;
    }
    
    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Set parent Acl Role Id
     * 
     * @param int $parent
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setParentId($parentId = null)
    {
        $this->_parentId = (int) $parentId;
        return $this;
    }
    
    /**
     * Get parent Acl Role Id
     * 
     * @return int
     */
    public function getParentId()
    {
        return $this->_parentId;
    }
    
    /**
     * Set Application_Acl_Roles::$_default
     * 
     * @param string $default
     * @return Application_Acl_Roles
     */
    public function setDefault($default = null)
    {
        $this->_default = (string) $default;
        return $this;
    }

    /**
     * Get Application_Acl_Roles::$_default
     * 
     * @return string
     */
    public function getDefault()
    {
        return $this->_default;
    }
    
    /**
     * Set translations
     * 
     * @param array $translations
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setTranslations($translations = true)
    {
        $this->_translations = (array) $translations;
        return $this;
    }
    
    /**
     * Get translations
     * 
     * @return array
     */
    public function getTranslations()
    {
        return $this->_translations;
    }
    
    /**
     * Get all Acl Roles from the DB Table.
     * 
     * Select all registered Acl Roles in the DB Table.
     * 
     * @param boolean $returnArray
     * @return array|null
     */
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse();
    }
    
    /**
     * Get Acl Role by id.
     * 
     * @return array|null
     */
    public function read()
    {
        $role = $this->getMapper()->read($this);
        $roleTranslations = Application_Model_Acl::factory('Roles_Translations')
                                             ->setRoleId($role['id'])
                                             ->getByRoleId();
        if (!empty($roleTranslations)) {
            
            $translations = array();
            
            foreach ($roleTranslations as $translation)
            {
                $translations[$translation['langId']] = $translation['title'];
            }
            
            $role['translations'] = $translations;
        }
        
        return $role;
    }
    
    /**
     * Get the default Acl Role from the DB Table.
     * 
     * @param string $default
     * @return array|null
     */
    public function readRoleByDefault($default = null)
    {
        return $this->getMapper()->readRoleByDefault($default);
    }
    
    /**
     * Create new Acl Role.
     * 
     * First create new row in the Acl Roles table,
     * than get primary key for the row and add (if any)
     * language translations to the Acl Role Translations table. 
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function insert()
    {
        $rowId = $this->getMapper()->insert($this);
        
        if (null !== $this->getTranslations()) {
            
            /**
             * Get the translations model.
             */
            $roleTranslationsModel = Application_Model_Acl::factory('Roles_Translations');
            $roleTranslationsModel->setRoleId($rowId);
            
            $translations = $this->getTranslations();
            foreach ($translations as $languageId => $translation) {
                $roleTranslationsModel->setOptions(array(
                    'langId' => (int) $languageId,
                    'title' => $translation
                ));
                $roleTranslationsModel->insert();
            }
        }
        
        return $this;
    }
    
    /**
     * Update Acl Role.
     * 
     * First update common options, then update every single
     * translation.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function update()
    {
        $this->getMapper()->update($this);
        
        $translations = $this->getTranslations();
        $roleId = $this->getId();
        $translationsModel = Application_Model_Acl::factory('Roles_Translations')
                                                  ->setRoleId($roleId);
        
        if (!empty($translations)) {
            foreach ($translations as $langId => $translation)
            {
                $translationsModel->setLangId($langId)
                                  ->setTitle($translation);
                $dbTranslation = $translationsModel->get();
                if (empty($dbTranslation)) {
                    $translationsModel->insert();
                } else {
                    $translationsModel->update();
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Delete Acl Role.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function delete()
    {
        $this->getMapper()->delete($this);
        return $this;
    }
}