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
 * @version    $Id: Language.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for languages.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Language extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'langs';

    /**
     * Add new language.
     * 
     * @param  Application_Model_Language $model 
     * @return int
     */
    public function insert(Application_Model_Language $model)
    {
        $data = array(
            'title'   => $model->getTitle(),
            'name'    => $model->getName(),
            'icon'    => $model->getIcon()
        );
        
        $phpAdapter = $model->getPhpAdapter();
        $jsAdapter = $model->getJsAdapter();
        
        if (!empty($phpAdapter)) {
            $data['phpAdapter'] = $model->getPhpAdapter();
        }
        
        if (!empty($jsAdapter)) {
            $data['jsAdapter'] = $model->getJsAdapter();
		}
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Delete language.
     * 
     * @param  Application_Model_Language $model 
     * @return int
     */
    public function delete(Application_Model_Language $model)
    {
        /** Get the adapter **/
        $adapter = $this->getDbTable()->getAdapter();
        
        /** Create the where clause **/
        if (!empty($model->name)) {
            $where[] = $adapter->quoteInto('name = ?', $model->getName());
        } else {
            $where[] = $adapter->quoteInto('id = ?', $model->getId());
        }
        		
        return $this->getDbTable()->delete($where);
    }

    /**
     * Edit language.
     * 
     * @param  Application_Model_Language $model 
     * @return void
     */
    public function update(Application_Model_Language $model)
    {
        $data = array(
            'title'   => $model->getTitle(),
            'name'    => $model->getName()
        );
        
        $phpAdapter = $model->getPhpAdapter();
        $jsAdapter = $model->getJsAdapter();
        $icon = $model->getIcon();
        
        if (!empty($phpAdapter)) {
            $data['phpAdapter'] = $phpAdapter;
        }
            
        if (!empty($jsAdapter)) {
            $data['jsAdapter'] = $jsAdapter;
        }
            
        if (!empty($icon)) {
            $data['icon'] = $icon;
        }
        
        $this->getDbTable()->update($data, array('id = ?' => $model->getId()));
    }

    /**
     * Get all languages from the db table.
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
     * Get one language from the db table.
     * 
     * @param  Application_Model_Language $model 
     * @return array
     */
    public function read(Application_Model_Language $model)
    {
        $adapter = $this->getAdapter();
        $name = $model->getName();
        
        // If name is not specified, select by id
        if (empty($name)) {
            $fields = array('`id` = ?');
            $values = array($model->getId());
        } else {
            $fields = array('`name` = ?');
            $values = array($model->getName());
        }
        
        $sql = vsprintf(
            'SELECT * FROM `' . $this->getDbTable()->info('name') . '` WHERE %s',
            array_map(array($adapter, 'quoteInto'), $fields, $values)
        );
        
        $result = $adapter->fetchRow($sql);
        
        return $result;
    }

    
}