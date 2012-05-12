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
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Privileges.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Acl Privileges.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Acl_Adapter_Privileges extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'acl_privileges';
    
    /**
     * Insert new Acl Privilege to the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function insert(Application_Model_Acl_Adapter_Abstract $model)
    {
        $data = array(
            'name' => $model->getName(),
            'resourceId' => $model->getResourceId()
        );
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Delete Acl Privilege by name and Acl Resource id.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return int
     */
    public function delete(Application_Model_Acl_Adapter_Abstract $model)
    {
        $where[] = $this->getAdapter()->quoteInto('name = ?', $model->getName(), 'STRING');
        $where[] = $this->getAdapter()->quoteInto('resourceId = ?', $model->getResourceId(), 'INTEGER');
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Get all registered Acl Privileges for a specific Acl Resource ID 
     * from the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function readByResourceId(Application_Model_Abstract $model)
    {        
        $dbTable = $this->getDbTable();
        /** Create the select clause. **/
        $select = $dbTable->select()
                          ->where('`resourceId` = ?', $model->getResourceId(), 'INTEGER');
        
        $result = $dbTable->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    /**
     * Get Acl Privilege by id or Acl Resource 
     * id an Acl Privilege name.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function read(Application_Model_Abstract $model)
    {        
        $dbTable = $this->getDbTable();
        
        /**
         * Get options
         */
        $id = $model->getId();
        $name = $model->getName();
        $resourceId = $model->getResourceId();
        
        /** Create the select clause. **/
        $select = $dbTable->select();
                          
        if (!empty($id)) {
            $select->where('id = ?', $id, 'INTEGER');
        } else
        if (!empty($name) & !empty($resourceId)) {
            $select->where('name = ?', $name, 'STRING')
                   ->where('resourceId = ?', $resourceId, 'INTEGER');
        } else {
            return null;
        }
        
        $result = $dbTable->fetchRow($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
}