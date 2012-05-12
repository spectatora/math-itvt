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
 * @version    $Id: Users.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for users.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Users extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'users';
    
    /**
     * Insert new user in the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function insert(Application_Model_Abstract $model)
    {
        $data = $model->toArray(true, array('mapper', 'errors', 'id', 'genres', 'keyword'));
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Get user by given options.
     * 
     * @param Application_Model_Abstract $model
     * @param array $allowed Fields to use for matching
     * @return array|null
     */
    public function read(Application_Model_Abstract $model, $allowed = array('id'))
    {
        $select = $this->getDbTable()->select();
        
        $this->_arrayToWhere($model->toArray(true, null, $allowed), 
                                                $select);
                
        $resultSet = $this->getDbTable()->fetchRow($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Delete user by given options.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function delete(Application_Model_Abstract $model)
    {        
        $where = $this->_arrayToWhere($model->toArray(true, null, array('id')));
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Update user.
     * 
     * @param Application_Model_Abstract $model
     * @param boolean $passEmpty
     * @param array|null
     * @return int
     */
    public function update(Application_Model_Abstract $model, $passEmpty = false, $allowed = null)
    {
        $data = $model->toArray($passEmpty, array(
            'mapper', 'errors', 'id', 'ipOfRegistration', 
            'key', 'genres', 'keyword'
        ), $allowed);
                
        /**
         * If the password was not changed (e.g $data['password'] is null),
         * remove the password entry from the $data array.
         */
        if (empty($data['password'])) {
            unset($data['password']);
        }
        
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Get user by given options.
     * 
     * @param Application_Model_Abstract $model
     * @param boolean $returnArray
     * @return array|null|Zend_Db_Select
     */
    public function browse(Application_Model_Abstract $model, $returnArray = true)
    {
        $select = $this->getDbTable()->select();
        
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Activate user registration.
     * 
     * Sets active to true.
     * 
     * @param Application_Model_Abstract $model
     * @return int 
     */
    public function activate(Application_Model_Abstract $model)
    {
        $data = array('active' => 1);
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId());
        return $this->getDbTable()->update($data, $where);
    }
}