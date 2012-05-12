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
 * @version    $Id: Files.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for CRUD Files model.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Mapper_Crud_Files extends Application_Model_Mapper_Abstract
{
    
    /**
     * Insert new row to the DB Table.
     * 
     * @param Tulipa_Model_Crud_Files $model
     * @return int
     */
    public function insert(Tulipa_Model_Crud_Files $model)
    {
        $files = $model->getFiles();
        
        if (empty($files)) {
            return null;
        }
        
        $parentColumn = $model->getParentColumn();
        $filenameColumn = $model->getFilenameColumn();
        
        $data = array($parentColumn => $model->getParentId());
        
        foreach ($files as $filename) 
        {
            if (isset($filename)) {
                $data[$filenameColumn] = $filename;
                $this->getDbTable()->insert($data);
            }
        }
    }
    
    /**
     * Read single row by primary key.
     * 
     * @param Tulipa_Model_Crud_Files $model
     * @param boolean $returnArray
     * @return array|null
     */
    public function read(Tulipa_Model_Crud_Files $model, $returnArray = true)
    {
                
        $select = $this->getDbTable()
                       ->select()
                       ->where('`' . $model->getPrimaryKeyColumn() . '` = ?',
                               $model->getId(), 'INTEGER');
        
                       
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchRow($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Delete row by id.
     * 
     * @param Tulipa_Model_Crud_Files $model
     * @return int
     */
    public function delete(Tulipa_Model_Crud_Files $model)
    {        
        $where = $this->getAdapter()->quoteInto($model->getPrimaryKeyColumn() . ' = ?', $model->getId(), 'INTEGER');
        return $this->getDbTable()->delete($where);
    }
    
    /**
     * Browse files with parent id.
     * 
     * @param Tulipa_Model_Crud_Files $model
     * @param boolean $returnArray
     * @return array|null|Zend_Db_Select
     */
    public function browse(Tulipa_Model_Crud_Files $model, $returnArray = true)
    {
        $select = $this->getDbTable()
                       ->select()
                       ->where('`' . $model->getParentColumn() . '` = ?', 
                               $model->getParentId(), 
                               'INTEGER');
                       
        if (!$returnArray) {
            return $select;
        }
        
        $resultSet = $this->getDbTable()->fetchAll($select);
                
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}