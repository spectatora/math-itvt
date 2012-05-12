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
 * @version    $Id: Access.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Acl Access.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Acl_Adapter_Access extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'acl_access';
    
    /**
     * Insert new Acl Rule.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return int Primary key
     */
    public function insert(Application_Model_Acl_Adapter_Abstract $model)
    {
        $data = array(
            'allow' => (int) $model->getAllow(),
            'roleId' => !$model->getRoleId() ? null : $model->getRoleId(),
            'resourceId' => $model->getResourceId(),
            'privilegeId' => !$model->getPrivilegeId() ? null : $model->getPrivilegeId()
        );
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Delete Acl Rule by id.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return int Count of rows deleted
     */
    public function delete(Application_Model_Acl_Adapter_Abstract $model)
    {
        $id = $model->getId();
        
        if (empty($id)) {
            return;
        }
        
        $where = $this->getAdapter()->quoteInto('id = ?', $id, 'INTEGER');
        
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Get DB Table name.
     * 
     * Get with Factory Method the appropriate instance,
     * get it's Data Mapper Model,
     * get the Zend_Db_Table instane and use the info() method
     * to get the name.
     * 
     * @param string $mapperName
     * @return string DB Table name
     */
    protected function _getCustomDbTableName($mapperName = null)
    {
        if (null === $mapperName) {
            return;
        }        
        return Application_Model_Acl::factory($mapperName)->getMapper()
                                                      ->getDbTable()
                                                      ->info('name'); 
    }
    
    /**
     * Get all registered Acl Access from the DB Table.
     * 
     * @return array|null
     */
    public function browse()
    {        
        $dbTable = $this->getDbTable();
        
        /** Get Acl Access table name **/
        $accessTableName = $dbTable->info('name');
        /** Get Acl Roles table name **/
        $rolesTableName = $this->_getCustomDbTableName('roles');  
        /** Get Acl Resources table name **/
        $resourcesTableName = $this->_getCustomDbTableName('resources');  
        /** Get Acl Privileges table name **/
        $privilegesTableName = $this->_getCustomDbTableName('privileges');
        
        /** Create the select clause. **/
        $select = $dbTable->select()
                          ->setIntegrityCheck(false)
                          ->from(array('access' => $accessTableName))
                          ->joinLeft(array('roles' => $rolesTableName), 
                                        '`access`.`roleId` = `roles`.`id`',
                                        array('roleName' => 'roles.name'))
                          ->joinLeft(array('resources' => $resourcesTableName), 
                                        '`access`.`resourceId` = `resources`.`id`',
                                        array('resourceName' => 'resources.name'))
                          ->joinLeft(array('privileges' => $privilegesTableName), 
                                        '`access`.`privilegeId` = `privileges`.`id`',
                                        array('privilegeName' => 'privileges.name'))
                          ->order('access.id DESC');
        
        $result = $dbTable->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    /**
     * Get Acl Rule by id from the DB Table.
     * 
     * @param Application_Model_Acl_Adapter_Abstract $model
     * @return array|null
     */
    public function read(Application_Model_Acl_Adapter_Abstract $model)
    {        
        $dbTable = $this->getDbTable();
        
        /** Get Acl Access table name **/
        $accessTableName = $dbTable->info('name');
        /** Get Acl Roles table name **/
        $rolesTableName = $this->_getCustomDbTableName('roles');  
        /** Get Acl Resources table name **/
        $resourcesTableName = $this->_getCustomDbTableName('resources');  
        /** Get Acl Privileges table name **/
        $privilegesTableName = $this->_getCustomDbTableName('privileges');
        
        /** Create the select clause. **/
        $select = $dbTable->select()
                          ->setIntegrityCheck(false)
                          ->from(array('access' => $accessTableName))
                          ->joinLeft(array('roles' => $rolesTableName), 
                                        '`access`.`roleId` = `roles`.`id`',
                                        array('roleName' => 'roles.name'))
                          ->joinLeft(array('resources' => $resourcesTableName), 
                                        '`access`.`resourceId` = `resources`.`id`',
                                        array('resourceName' => 'resources.name'))
                          ->joinLeft(array('privileges' => $privilegesTableName), 
                                        '`access`.`privilegeId` = `privileges`.`id`',
                                        array('privilegeName' => 'privileges.name'))
                          ->where('access.id = ?', $model->getId(), 'INTEGER');
        
        $result = $dbTable->fetchRow($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
}