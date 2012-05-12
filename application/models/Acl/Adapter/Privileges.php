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
 * @version    $Id: Privileges.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Acl Privileges Model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl_Adapter_Privileges extends Application_Model_Acl_Adapter_Abstract
                                       implements Application_Bread_Interface
{    
    /**
     * Acl Privilege id.
     * 
     * @var int
     */
    protected $_id = null;
    
    /**
     * Acl Privilege name.
     * 
     * @var string
     */
    protected $_name = null;
    
    /**
     * Acl Resource ID.
     * 
     * @var int
     */
    protected $_resourceId = null;
    
    /**
     * Set Acl Privilege Id
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
     * Get Acl Privilege Id
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
     * Get all Acl Privileges from the DB Table.
     * 
     * Select all registered Acl Privileges in the DB Table.
     * 
     * @return array|null
     */
    public function readByResourceId()
    {
        return $this->getMapper()
                    ->readByResourceId($this);
    }
    
    public function browse($returnArray = false)
    {
        throw new Zend_Exception('The browse() method is not available in this class');
    }
    
    /**
     * Get Acl Privilege by id or Acl Resource 
     * id and Acl Privilege name.
     * 
     * @return array|null
     */
    public function read()
    {
        return $this->getMapper()
                    ->read($this);
    }
        
    /**
     * Get privileges and build array 
     * that is ready to be compared.
     * 
     * @return array|null
     */
    public function readByResourceIdReady()
    {
        $privileges = $this->readByResourceId();
        
        if (!empty($privileges)) {
            foreach ($privileges as $privilege)
            {
                $ready[$privilege['id']] = $privilege['name'];
            }
            
            return $ready;
        }
        
        return null;
    }
    
    /**
     * Add Acl Privilege to the DB Table.
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
     * Delete Acl Privilege by name and Acl Resource id.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function delete()
    {
        $this->getMapper()->delete($this);
        return $this;
    }
    
    public function update()
    {
        throw new Zend_Exception('The update() method is not available for this class');
    }
    
    /**
     * Get all Acl Privileges from the DB Table.
     * 
     * Select all registered Acl Privileges in the DB Table. Static method.
     * 
     * @param int $resourceId
     * @return array|null|void
     */
    public static function readByResourceIdStatic($resourceId = null)
    {
        if (null === $resourceId) {
            return;
        }
        
        $model = self::getInstance();
        
        return $model->setResourceId($resourceId)
                     ->readByResourceId();
    }
}