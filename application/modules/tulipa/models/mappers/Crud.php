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
 * @version    $Id: Crud.php 186 2011-09-22 21:48:27Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Crud.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Mapper_Crud extends Application_Model_Mapper_Abstract
{
    
    /**
     * Insert new row to the DB Table.
     * 
     * @param Tulipa_Model_Abstract $model
     * @return int
     */
    public function insert(Tulipa_Model_Crud $model)
    {
        $data = $model->getData();
        
        foreach ($data as $field => $value) {
            if (null === $value) {
                unset($data[$field]);
            }
        }
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Delete row by id.
     * 
     * @param Tulipa_Model_Crud $model
     * @return int
     */
    public function delete(Tulipa_Model_Crud $model)
    {        
        $where = $this->getAdapter()->quoteInto($model->getPrimaryKeyColumn() . ' = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Update row by id.
     * 
     * @param Tulipa_Model_Crud $model
     * @return int
     */
    public function update(Tulipa_Model_Crud $model)
    {
        $data = $model->getData(true);
                
        $where = $this->getAdapter()->quoteInto($model->getPrimaryKeyColumn() . ' = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Read single row by primary key.
     * 
     * @param Tulipa_Model_Crud $model
     * @param boolean $returnArray
     * @return array|null
     */
    public function read(Tulipa_Model_Crud $model, $returnArray = true)
    {
        $columnsForSelect = $model->getColumnsForSelect();
        
        array_unshift($columnsForSelect, $model->getPrimaryKeyColumn());
        
        $select = $this->getDbTable()
                       ->select()
                       ->setIntegrityCheck(false)
                       ->from(array('default' => $this->getDbTable()->info('name')), $columnsForSelect);
                               
        $langModel = $model->getLangModel();
                       
        if (isset($langModel)) {
            $select->joinLeft(array('t' => $langModel->getDbTableName()), 
            				  '`t`.`' . $langModel->getParentColumn() 
                              . '` = `default`.`' . $model->getPrimaryKeyColumn() . '`',
                              $langModel->getColumnsForSelect());
            $langId = Application_Model_Language::getSessionLang()->id;
            $select->where('`t`.`' . $langModel->getLangColumn() . '` = ?', $langId, 'INTEGER');
        }
        
        $id = $model->getId();
        if (isset($id)) {
            $select->where('`default`.`' . $model->getPrimaryKeyColumn() . '` = ?', $id, 'INTEGER');
        }
        
        // Additional where conditions
        $extraWhereConds = $model->getWhere();
        if (isset($extraWhereConds) && is_array($extraWhereConds)) {
            foreach ($extraWhereConds as $cond) {
                call_user_func_array(array($select, 'where'), $cond);
            }
        }
        
        // Additional having conditions
        $extraHavingConds = $model->getHaving();
        if (isset($extraHavingConds) && is_array($extraHavingConds)) {
            foreach ($extraHavingConds as $cond) {
                call_user_func_array(array($select, 'having'), $cond);
            }
        }
        
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchRow($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }

    /**
     * Browse all rows.
     * 
     * @param Tulipa_Model_Crud $model
     * @param boolean $returnArray
     * @return array|null|Zend_Db_Select
     */
    public function browse(Tulipa_Model_Crud $model, $returnArray = true)
    {
        
        $columnsForSelect = $model->getColumnsForSelect();
        
        if (!in_array($model->getPrimaryKeyColumn(), $columnsForSelect) && !in_array('*', $columnsForSelect)) {
            array_unshift($columnsForSelect, $model->getPrimaryKeyColumn());
        }
        
        $select = $this->getDbTable()
                       ->select()
                       ->setIntegrityCheck(false)
                       ->from(array('default' => $this->getDbTable()->info('name')), $columnsForSelect);
                               
        $langModel = $model->getLangModel();

        /** Merge with translations table **/
        if (isset($langModel)) {
            $select->joinLeft(array('t' => $langModel->getDbTableName()), 
            				  '`t`.`' . $langModel->getParentColumn() 
                              . '` = `default`.`' . $model->getPrimaryKeyColumn() . '`',
                              $langModel->getColumnsForSelect());
            $langId = Application_Model_Language::getSessionLang()->id;
            $select->where('`t`.`' . $langModel->getLangColumn() . '` = ?', $langId, 'INTEGER');
        }
        
        $extraOrderClause = $model->getOrder();
        if (isset($model->getCrudConfig()->browse->order->by) && empty($extraOrderClause)) {
            if (isset($model->getCrudConfig()->browse->order->desc) && 
                        $model->getCrudConfig()->browse->order->desc) {
                $select->order($model->getCrudConfig()->browse->order->by . ' DESC');
            } else {                
                $select->order($model->getCrudConfig()->browse->order->by);
            }
        } else {
            $select->order($extraOrderClause);
        }
        
        // Additional where conditions
        $extraWhereConds = $model->getWhere();
        if (isset($extraWhereConds) && is_array($extraWhereConds)) {
            foreach ($extraWhereConds as $cond) {
                call_user_func_array(array($select, 'where'), $cond);
            }
        }
        
        // Additional having conditions
        $extraHavingConds = $model->getHaving();
        if (isset($extraHavingConds) && is_array($extraHavingConds)) {
            foreach ($extraHavingConds as $cond) {
                call_user_func_array(array($select, 'having'), $cond);
            }
        }
        
        // Additional limit
        $extraLimit = $model->getLimit();
        if (isset($extraLimit)) {
            $select->limit($extraLimit);
        }
        
        // Additional group by
        $extraGroup = $model->getGroup();
        if (isset($extraGroup)) {
            $select->group($extraGroup);
        }
        
        if (!$returnArray) {
            return $select;
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}