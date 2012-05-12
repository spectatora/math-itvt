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
 * @version    $Id: Roles.php 144 2011-08-01 22:20:02Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Acl Roles.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Acl_Adapter_Roles extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'acl_roles';
    
    /**
     * Add new Acl Role.
     * 
     * @param Application_Model_Acl_Adapter_Roles $model
     * @return int Primary key of the inserted row
     */
    public function insert(Application_Model_Acl_Adapter_Roles $model)
    {
        $data = array(
            'name' => $model->getName(),
            'parentId' => $model->getParentId() == 0 ? null : $model->getParentId()
        );
        
        /**
         * If this Acl Role is set to be default,
         * unset the current default Acl Role.
         */
        $data['default'] = $model->getDefault();
        if (!empty($data['default'])) {
            $this->_clearRoleDefault($data['default']);
        }
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Update Acl Role.
     * 
     * @param Application_Model_Acl_Adapter_Roles $model
     * @return int Primary key of the inserted row
     */
    public function update(Application_Model_Acl_Adapter_Roles $model)
    {
        $data = array(
            'name' => $model->getName(),
            'parentId' => $model->getParentId() == 0 ? null : $model->getParentId()
        );
        
        /**
         * If this Acl Role is set to be default,
         * unset the current default Acl Role.
         */
        $data['default'] = $model->getDefault();
        if (!empty($data['default'])) {
            $this->_clearRoleDefault($data['default']);
        }
        
        $where = array(
            'id = ?' => $model->getId()
        );
              
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Delete Acl Role.
     * 
     * @param Application_Model_Acl_Adapter_Roles $model
     * @return int
     */
    public function delete(Application_Model_Acl_Adapter_Roles $model)
    {
        return $this->getDbTable()
                    ->delete(
                        $this->getAdapter()
                             ->quoteInto('id = ?', $model->getId(), 'INTEGER')
                    );
    }
    
    /**
     * Clear the current default Acl Role.
     * 
     * @param string $default
     * @return int
     * @throws Application_Model_Mapper_Acl_Roles_Exception
     */
    protected function _clearRoleDefault($default = null)
    {
        if (empty($default)) {
            throw new Zend_Exception('Default parameter not set');
        }
        
        $adapter = $this->getAdapter();
        
        $data = array(
            'default' => null
        );
        
        return $this->getDbTable()->update($data, $adapter->quoteInto('`default` = ?', $default));
    }
    
    /**
     * Get all registered Acl Roles from the DB Table.
     * 
     * @return array|null
     */
    public function browse()
    {        
        $dbTable = $this->getDbTable();
        /** Get table name **/
        $tableName = $dbTable->info('name');
        /** Create the select query. **/
        $select = $dbTable->select()
                          ->setIntegrityCheck(false)
                          ->from(array('child' => $tableName))
                          ->joinLeft(array('parent' => $tableName), 
                                        '`parent`.`id` = `child`.`parentId`', 
                                        array('parentName' => 'parent.name'))
                          ->joinLeft(array('translationsTable' => 'acl_roles_translations'),
                                        '`child`.`id` = `translationsTable`.`roleId`',
                                        new Zend_Db_Expr('GROUP_CONCAT(`translationsTable`.`langId`, ' 
                                                            . ' \' - \', `translationsTable`.`title`) ' 
                                                            . ' AS `translations`'))
                          ->order('child.parentId')
                          ->group('child.id');
        
        $result = $dbTable->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    /**
     * Get Acl Roles by id.
     * 
     * @param Application_Model_Acl_Adapter_Roles $model
     * @return array|null
     */
    public function read(Application_Model_Acl_Adapter_Roles $model)
    {        
        $dbTable = $this->getDbTable();
        /** Get table name **/
        $tableName = $dbTable->info('name');
        /** Create the select query. **/
        $select = $dbTable->select()
                          ->setIntegrityCheck(false)
                          ->from(array('child' => $tableName))
                          ->joinLeft(array('parent' => $tableName), 
                                        '`parent`.`id` = `child`.`parentId`', 
                                        array('parentName' => 'parent.name', 
                                                'parentDefault' => 'parent.default'))
                          ->order('child.parentId')
                          ->where('child.id = ?', $model->getId(), 'INTEGER');
        
        $result = $dbTable->fetchRow($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    
    
    /**
     * Get the default Acl Role from the DB Table.
     * 
     * @param string $default
     * @return array|null
     */
    public function readRoleByDefault($default = null)
    {
        $adapter = $this->getAdapter();
        
        $sql = vsprintf(
            'SELECT * FROM `' . $this->getDbTable()->info('name') . '` WHERE %s',
            array_map(array($adapter, 'quoteInto'), array('`default` = ?'), array($default))
        );
        
        $result = $adapter->fetchRow($sql);
        
        return $result;
    }
    
}