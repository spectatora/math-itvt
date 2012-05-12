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
 * @version    $Id: Lang.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Crud Language model.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Mapper_Crud_Lang extends Application_Model_Mapper_Abstract
{
    
    /**
     * Insert new row to the DB Table.
     * 
     * @param Tulipa_Model_Crud_Lang $model
     * @return int
     */
    public function insert(Tulipa_Model_Crud_Lang $model)
    {
        $data = $model->getData();
        
        $data[$model->getParentColumn()] = $model->getParentId();
        $data[$model->getLangColumn()] = $model->getLangId();
                
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Update row by id.
     * 
     * @param Tulipa_Model_Crud_Lang $model
     * @return int
     */
    public function update(Tulipa_Model_Crud_Lang $model)
    {
        $data = $model->getData();
        
        $where[] = $this->getAdapter()->quoteInto($model->getParentColumn() . ' = ?', $model->getParentId(), 'INTEGER');
        $where[] = $this->getAdapter()->quoteInto($model->getLangColumn() . ' = ?', $model->getlangId(), 'INTEGER');
        
        
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Browse all translations.
     * 
     * @param Tulipa_Model_Crud_Lang $model
     * @param boolean $returnArray
     * @return array|null|Zend_Db_Select
     */
    public function browse(Tulipa_Model_Crud_Lang $model, $returnArray = true)
    {
        $select = $this->getDbTable()
                       ->select()
                       ->where($model->getParentColumn() . ' = ?', $model->getParentId(), 'INTEGER');
                       
        
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}