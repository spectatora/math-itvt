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
 * @version    $Id: Resources.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Acl Resources.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Acl_Adapter_Resources extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'acl_resources';
    
    /**
     * Insert new Acl Resource to the DB Table.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return int|null
     */
    public function insert(Application_Model_Acl_Adapter_Abstract $model)
    {
        $data = array(
            'name' => $model->getName(),
            'parentId' => $model->getParentId() 
        );
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Delete Acl Resource by id.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return int
     */
    public function delete(Application_Model_Acl_Adapter_Abstract $model)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Get all registered Acl Resources from the DB Table.
     * 
     * @return array|null
     */
    public function browse()
    {        
        $dbTable = $this->getDbTable();
        /** Get table name **/
        $tableName = $dbTable->info('name');
        /** Create the select clause. **/
        $select = $dbTable->select()
                          ->setIntegrityCheck(false)
                          ->from(array('child' => $tableName))
                          ->joinLeft(array('parent' => $tableName), 
                                        '`parent`.`id` = `child`.`parentId`', 
                                        array('parentName' => 'parent.name'))
                          ->order('child.parentId');
        
        $result = $dbTable->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    /**
     * Get Acl Resource by name or id.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return array|null
     */
    public function read(Application_Model_Acl_Adapter_Abstract $model)
    {
        $id = $model->getId();
        $name = $model->getName();
        
        if (!empty($id)) {
            $where = $this->getAdapter()->quoteInto('id = ?', $id, 'INTEGER');
        } else
        if (!empty($name)) {
            $where = $this->getAdapter()->quoteInto('name = ?', $name, 'STRING');
        } else {
            return null;
        }
        
        $select = $this->getDbTable()->select()->where($where);
        
        $result = $this->getDbTable()->fetchRow($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
}