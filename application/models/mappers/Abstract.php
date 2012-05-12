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
 * @version    $Id: Abstract.php 144 2011-08-01 22:20:02Z sasquatch@bgscripts.com $
 */

/**
 * Abstract class for Data Mapper Models.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
abstract class Application_Model_Mapper_Abstract
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = null;
    
    /**
     * DB Table Model class name.
     * 
     * @var string
     */
    protected $_dbTableModel = null;
    
    /**
     * Primary key column for the DB Table.
     * 
     * @var string
     */
    protected $_primaryKeyColumn = 'id';

    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Application_Model_Mapper_Abstract
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    /**
     * Get registered Zend_Db_Table instance
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
                        
            if (!empty($this->_dbTableModel)) {
                $dbTable = new $this->_dbTableModel(
                    array(
                        'name' => $this->_dbTableNameSuffix,
                        'primary' => $this->_primaryKeyColumn
                    )
                );
            } else { 
                $dbTable = new Application_Db_Table(
                    array(
                        'name' => $this->_dbTableNameSuffix,
                        'primary' => $this->_primaryKeyColumn
                    )
                );
            }
            
            $this->setDbTable($dbTable);
        }
        return $this->_dbTable;
    }
    
    /**
     * Set Application_Model_Mapper_Abstract::$_dbTableNameSuffix
     *
     * @param string $dbTableNameSuffix
     * @return Application_Model_Mapper_Abstract
     */
    public function setDbTableNameSuffix($dbTableNameSuffix = null)
    {
        $this->_dbTableNameSuffix = (null === $dbTableNameSuffix) ? null : 
                                    (string) $dbTableNameSuffix;
        return $this;
    }

    /**
     * Get Application_Model_Mapper_Abstract::$_dbTableNameSuffix
     *
     * @return string
     */
    public function getDbTableNameSuffix()
    {
        return $this->_dbTableNameSuffix;
    }
    
    /**
     * Get the adapter object of the DB Table.
     * 
     * @return Zend_Db_Adapter_Abstract
     */
    public function getAdapter()
    {
        return $this->getDbTable()->getAdapter();
    }
    
    /**
     * Quote array values.
     * 
     * Ready for query.
     * 
     * @param array $array
     * @param Zend_Db_Select $selectObject
     * @throws Application_Model_Mapper_Exception
     * @return array|null
     */
    protected function _arrayToWhere($array = null, $selectObject = null)
    {
        if (null === $array) {
            return null;
        }
        
        if (!empty($selectObject) & !($selectObject instanceof Zend_Db_Select)) {           
            throw new Application_Model_Mapper_Exception('$selectObject must be instance of Zend_Db_Select');
        }
        
        foreach ($array as $key => $value) {
            $type = strtoupper(gettype($value));
            if (!empty($selectObject)) {
                $selectObject->where('`' . $key . '` = ?', $value, $type);
            }
            $where[] = $this->getAdapter()->quoteInto($key . ' = ?', $value, $type);
        }
        
        return empty($where) ? null : $where;
    }
}