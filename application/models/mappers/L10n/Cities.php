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
 * @version    $Id: Cities.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for cities.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_L10n_Cities extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'cities';
    
    /**
     * Insert new city in the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function insert(Application_Model_Abstract $model)
    {
        $data = $model->toArray();
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Browse all cities in the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function browse(Application_Model_Abstract $model)
    {
        $citiesDbTableName = $this->getDbTable()->info('name');
        $countriesDbTableName = Application_Model_L10n::factory('countries')
                                                      ->getDbTableName();
        $select = $this->getDbTable()->select()
                                     ->setIntegrityCheck(false)
                                     ->from(array('cities' => $citiesDbTableName))
                                     ->joinLeft(array('countries' => $countriesDbTableName), 
                                                'countries.id = cities.countryId', 
                                                array('countryIcon' => 'countries.icon', 'countryName' => 'countries.name'))
                                     ->order('cities.id DESC');
        
        $where = $model->toArray();
        
        $this->_arrayToWhere($where, $select);
        
        $resultSet = $this->getDbTable()->fetchAll($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Read single city from the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function read(Application_Model_Abstract $model)
    {
        $select = $this->getDbTable()
                       ->select();
                       
        $this->_arrayToWhere($model->toArray(), $select);
        
        $resultSet = $this->getDbTable()->fetchRow($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Update city in the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function update(Application_Model_Abstract $model)
    {
        $data = $model->toArray(false);
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId(), 'INTEGER');        
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Delete city from the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function delete(Application_Model_Abstract $model)
    {
        $where = $this->getAdapter()->quoteInto('id = ?', $model->getId(), 'INTEGER');        
        return $this->getDbTable()->delete($where);
    }
}