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
 * @version    $Id: View.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for users DB View.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Users_View extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'users_view';
    
    /**
     * Get user by given options.
     * 
     * @param Application_Model_Abstract $model
     * @param array $allowed Fields to use for matching
     * @return array|null
     */
    public function read(Application_Model_Abstract $model, $allowed = array('id'))
    {
        $select = $this->getDbTable()
                       ->select()
                       ->from($this->getDbTable(), array(new Zend_Db_Expr('*'), 
                                new Zend_Db_Expr('HOUR(TIMEDIFF(NOW(), lastCheck)) AS `lastCheckTimeDiff`')));
        
        $this->_arrayToWhere($model->toArray(false, null, $allowed), 
                                                $select);
                
        $resultSet = $this->getDbTable()->fetchRow($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Get field by given options.
     * 
     * @param Application_Model_Abstract $model
     * @param array $allowed Fields to use for matching
     * @param string $fieldName Field to return
     * @return string|null
     */
    public function readOne(Application_Model_Abstract $model, $allowed = array(), $fieldName = null)
    {
        if (empty($fieldName)) {
            return;
        }
        
        $select = $this->getDbTable()
                       ->select()
                       ->from($this->getDbTable(), array(new Zend_Db_Expr($fieldName)));
        
        $this->_arrayToWhere($model->toArray(false, null, $allowed),
                                                $select);
        
        return $this->getAdapter()->fetchOne($select);
    }
    
    /**
     * Browse users by given options.
     * 
     * If $allowed is set and it's array, this method searches the DB Table
     * with using array's values as col names.
     * 
     * @param Application_Model_Abstract $model
     * @param boolean $returnArray
     * @param array $allowed Fields to use for matching
     * @return array|null|Zend_Db_Select
     */
    public function browse(Application_Model_Abstract $model, $returnArray = true, $allowed = null)
    {
        $select = $this->getDbTable()->select();
        
        if (null !== $allowed && is_array($allowed)) {
            $this->_arrayToWhere($model->toArray(true, null, $allowed), $select);
        }
        
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Search users database.
     * 
     * @param Application_Model_Abstract $model
     * @param boolean $returnArray Return result as array
     * @return array|null|Zend_Db_Select
     */
    public function search(Application_Model_Abstract $model, $returnArray = false)
    {
        $select = $this->getDbTable()->select();
        
        $this->_arrayToWhere($model->toArray(true, null, array('genre', 'countryId', 'cityId')), $select);
        
        $keyword = $model->getKeyword();
        
        if (!empty($keyword)) {
        	$keyword = Zend_Filter::filterStatic($keyword, 'alnum');
        	$select->where('`username` LIKE ?', '%' . $model->getKeyword() . '%', 'STRING');
        }
                
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}