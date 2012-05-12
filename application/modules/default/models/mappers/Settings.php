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
 * @category   Default
 * @package    Default_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Settings.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for common website settings.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_Mapper_Settings extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'settings';
    
    /**
     * Primary key column for the DB Table.
     * 
     * @var string
     */
    protected $_primaryKeyColumn = 'name';
    
    /**
     * Update setting.
     * 
     * @param Default_Model_Abstract $model
     * @return int
     */
    public function update(Default_Model_Abstract $model)
    {
        $data = $model->toArray(false, null, array('content'));
        $where = $this->getAdapter()->quoteInto('name = ?', $model->getName(), 'STRING');
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Read setting by name.
     * 
     * @param Default_Model_Abstract $model
     * @return array|null
     */
    public function read(Default_Model_Abstract $model)
    {
        $adapter = $this->getAdapter();
        
        $sql = vsprintf(
            'SELECT * FROM `' . $this->getDbTable()->info('name') . '` WHERE %s',
            array_map(array($adapter, 'quoteInto'), array('`name` = ?'), array($model->getName()))
        );
        
        $result = $adapter->fetchRow($sql);
        
        return $result;
    }
    
    /**
     * Get single field by setting name.
     * 
     * @param Default_Model_Abstract $model
     * @param string $fieldName
     * @return string|null
     */
    public function readOne(Default_Model_Abstract $model, $fieldName = null)
    {
        $adapter = $this->getAdapter();
        
        $sql = vsprintf(
            'SELECT `' . addslashes($fieldName) . '` FROM `' . $this->getDbTable()->info('name') . '` WHERE %s',
            array_map(array($adapter, 'quoteInto'), array('`name` = ?'), array($model->getName()))
        );
        
        $result = $adapter->fetchOne($sql);
        
        return $result;
    }
    
    /**
     * Browse all settings.
     * 
     * @param Default_Model_Abstract $model
     * @param boolean $returnArray Return result as array.
     * @return array|null|Zend_Db_Select
     */
    public function browse(Default_Model_Abstract $model, $returnArray = false)
    {
        $select = $this->getDbTable()
                       ->select();
        
        if (!$returnArray) {
        	return $select;
        }                       
                       
        $resultSet = $this->getDbTable()->fetchAll($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}