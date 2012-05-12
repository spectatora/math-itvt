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
 * @version    $Id: Access.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Acl Access Model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl_Adapter_Access extends Application_Model_Acl_Adapter_Abstract
                                   implements Application_Bread_Interface
{    
    /**
     * Acl Access id.
     * 
     * @var int
     */
    protected $_id = null;
    
    /**
     * Is this rule allowed or not?
     * 
     * @var boolean
     */
    protected $_allow = false;
    
    /**
     * Acl Role id.
     * 
     * @var int
     */
    protected $_roleId = null;
    
    /**
     * Acl Resource id.
     * 
     * @var int
     */
    protected $_resourceId = null;
    
    /**
     * Acl Privilege id.
     * 
     * @var int
     */
    protected $_privilegeId = null;
    
    /**
     * Set Acl Access Id
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
     * Get Acl Access Id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set Acl Access allowed
     * 
     * @param boolean $allow
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setAllow($allow = true)
    {
        $this->_allow = (boolean) $allow;
        return $this;
    }
    
    /**
     * Get is Acl Access allowed
     * 
     * @return boolean
     */
    public function getAllow()
    {
        return $this->_allow;
    }
    
    /**
     * Set Acl Role ID.
     * 
     * @param int $roleId
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setRoleId($roleId)
    {
        $this->_roleId = (int) $roleId;
        return $this;
    }
    
    /**
     * Get Acl Role ID.
     * 
     * @return int
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }
    
    /**
     * Set Acl Resource ID.
     * 
     * @param int $resourceId
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setResourceId($resourceId)
    {
        $this->_resourceId = (int) $resourceId;
        return $this;
    }
    
    /**
     * Get Acl Resource ID.
     * 
     * @return int
     */
    public function getResourceId()
    {
        return $this->_resourceId;
    }
    
    /**
     * Set Acl Privilege ID.
     * 
     * @param int $privilegeId
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setPrivilegeId($privilegeId)
    {
        $this->_privilegeId = (int) $privilegeId;
        return $this;
    }
    
    /**
     * Get Acl Privilege ID.
     * 
     * @return int
     */
    public function getPrivilegeId()
    {
        return $this->_privilegeId;
    }
    
    /**
     * Insert new Acl Access Rule.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function insert()
    {
        $id = $this->getMapper()->insert($this);
        $this->setId($id);
        return $this;
    }
    
    /**
     * Delete Acl Rule by id.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function delete()
    {
        $this->getMapper()->delete($this);
        return $this;
    }
    
    /**
     * Get all Acl Access from the DB Table.
     * 
     * Select all registered Acl Access in the DB Table.
     * 
     * @param boolean $returnArray
     * @return array|null
     */
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse();
    }
    
    /**
     * Get Acl Rule by id.
     * 
     * @return array|null
     */
    public function read()
    {
        return $this->getMapper()->read($this);
    }
    
    public function update()
    {
        throw new Zend_Exception('The update() method is not available for this class');
    }
}