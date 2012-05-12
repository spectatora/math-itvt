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
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Notifications.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for notifications.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Mapper_Notifications extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'tulipa_notifications';
    
    /**
     * Insert new notification to the DB Table.
     * 
     * @param Tulipa_Model_Abstract $model
     * @return int
     */
    public function insert(Application_Model_Abstract $model)
    {
        $data = $model->toArray(true, null, array('content', 'title'));
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Delete notification by id.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function delete(Application_Model_Abstract $model)
    {        
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Update notification by id.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function update(Application_Model_Abstract $model)
    {
        $data = $model->toArray(true, null, array('content', 'title', 'isViewed'));
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Get notification by given options.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function read(Application_Model_Abstract $model)
    {
        $select = $this->getDbTable()
                       ->select()
                       ->where('id = ?', $model->getId(), 'INTEGER');
        
        $resultSet = $this->getDbTable()->fetchRow($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }

    /**
     * Browse all notifications.
     * 
     * @param Application_Model_Abstract $model
     * @param boolean $returnArray
     * @return array|null|Zend_Db_Select
     */
    public function browse(Application_Model_Abstract $model, $returnArray = true)
    {
        
        $select = $this->getDbTable()
                       ->select()
                       ->order('id DESC');
                       
        $this->_arrayToWhere($model->toArray(true, null, array('isViewed')), $select);
         
        if (!$returnArray) {
            return $select;
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}