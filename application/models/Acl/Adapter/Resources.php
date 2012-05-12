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
 * @version    $Id: Resources.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Acl Resources Model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl_Adapter_Resources extends Application_Model_Acl_Adapter_Abstract
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
    protected $_parentId = null;
    
    /**
     * Set Acl Resource Id
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
     * Get Acl Resource Id
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
     * Set Acl Resource parent id.
     * 
     * @param int $parentId
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setParentId($parentId)
    {
        $this->_parentId = (int) $parentId;
        return $this;
    }
    
    /**
     * Get Acl Resource parent id.
     * 
     * @return int
     */
    public function getParentId()
    {
        return $this->_parentId;
    }
    
    /**
     * Add new Acl Resource to the DB Table.
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
     * Delete Acl Resource by id.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function delete()
    {
        $this->getMapper()->delete($this);
        return $this;
    }
    
    /**
     * Get all resources from the DB Table.
     * 
     * Select all registered Acl Resources in the DB Table.
     * 
     * @param boolean $returnArray
     * @return array|null
     */
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse();
    }
    
    /**
     * Get resources and build array 
     * that is ready to be compared.
     * 
     * @return array|null
     */
    public function browseReady()
    {
        $resources = $this->browse();
        
        if (!empty($resources)) {
            foreach ($resources as $resource)
            {
                $ready[$resource['id']] = $resource['name'];
            }
            
            return $ready;
        }
        
        return null;
    }
    
    /**
     * Get Acl Resource by name ot id.
     * 
     * @return array|null
     */
    public function read()
    {
        return $this->getMapper()->read($this);
    }
    
    public function update()
    {
        throw new Zend_Exception('The update() method is not available in this class');
    }
}