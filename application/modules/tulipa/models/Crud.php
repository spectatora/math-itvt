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
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Crud.php 186 2011-09-22 21:48:27Z sasquatch@bgscripts.com $
 */

/**
 * CRUD model. Implements BREAD ({@see Application_Bread_Interface})
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Crud extends Tulipa_Model_Abstract
                        implements Application_Bread_Interface
{
    
    /**
     * DB table name.
     * 
     * @var string
     */
    protected $_table = null;

    /**
     * Primary key column. Usually is 'id'
     * 
     * @var string
     */
    protected $_primaryKeyColumn = 'id';

    /**
     * Multilingual model instance.
     * 
     * @var Tulipa_Model_Crud
     */
    protected $_langModel = null;
    
	/**
	 * Colums that will be used with SELECT.
	 * 
	 * Example: array('name', 'title', 'content')
	 * 
     * @var array
     */
    protected $_columnsForSelect = array('*');
    
    /**
     * Data for insert/update.
     * 
     * @var array
     */
    protected $_data = null;
    
    /**
     * @var int
     */
    protected $_id = null;

    /**
     * Params for the where clause.
     * @var array
     */
    protected $_where = null;
    
    /**
     * @var array
     */
    protected $_having = null;
    
    /**
     * Additional order clause.
     * @var string
     */
    protected $_order = null;

    /**
     * Additional limit.
     * @var int
     */
    protected $_limit = null;
    
    /**
     * @var string
     */
    protected $_group = null;
    /**
     * @var array
     */
    protected $_subModules = null;
    
    /**
     * @var Zend_Config
     */
    protected $_crudConfig = null;
    
    /**
     * @var Tulipa_Model_Crud_Extra_Interface
     */
    protected $_extraModel = null;
    
    /**
     * Get data mapper
     *
     * Loads mapper instance if no mapper registered.
     * 
     * @param string $mapperName
     * @return Application_Model_Mapper_Abstract|void
     */
    public function getMapper($mapperName = null)
    {
        $mapper = parent::getMapper($mapperName);
        $mapper->setDbTableNameSuffix($this->getTable());
        return $mapper;
    }
    
    /**
     * Set Tulipa_Model_Crud::$_table
     *
     * @param string $table
     * @return Tulipa_Model_Crud
     */
    public function setTable($table = null)
    {
        $this->_table = (null === $table) ? null : (string) $table;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Set Tulipa_Model_Crud::$_primaryKeyColumn
     *
     * @param string $primaryKeyColumn
     * @return Tulipa_Model_Crud
     */
    public function setPrimaryKeyColumn($primaryKeyColumn = null)
    {
        $this->_primaryKeyColumn = (null === $primaryKeyColumn) ? null : (string) $primaryKeyColumn;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_primaryKeyColumn
     *
     * @return string
     */
    public function getPrimaryKeyColumn()
    {
        return $this->_primaryKeyColumn;
    }

    /**
     * Set Tulipa_Model_Crud::$_langModel
     *
     * @param Tulipa_Model_Crud_Lang $langModel
     * @return Tulipa_Model_Crud
     */
    public function setLangModel(Tulipa_Model_Crud_Lang $langModel = null)
    {
        if (is_string($langModel)) {
            $this->_langModel = new $langModel;
        } else {
            $this->_langModel = $langModel;
        }
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_langModel
     *
     * @return Tulipa_Model_Crud_Lang
     */
    public function getLangModel()
    {
        return $this->_langModel;
    }

    /**
     * Set Tulipa_Model_Crud::$_columnsForSelect
     *
     * @param array $columnsForSelect
     * @return Tulipa_Model_Crud
     */
    public function setColumnsForSelect($columnsForSelect = null)
    {
        $this->_columnsForSelect = (null === $columnsForSelect) ? null : (array) $columnsForSelect;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_columnsForSelect
     *
     * @return array
     */
    public function getColumnsForSelect()
    {
        return $this->_columnsForSelect;
    }

    /**
     * Set Tulipa_Model_Crud::$_data
     *
     * @param array $data
     * @return Tulipa_Model_Crud
     */
    public function setData($data = null)
    {
        $this->_data = (null === $data) ? null : (array) $data;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_data
     *
     * @param boolean $skipEmpty If true - skip entries with empty values
     * @return array
     */
    public function getData($skipEmpty = false)
    {
        if (!$skipEmpty | empty($this->_data)) {
            return $this->_data;
        } else {
            $data = $this->_data;
            foreach ($data as $key => &$value) {
                if ($value == null) {
                    $value = null;
                }
            }
            return $data;
        }
    }

    /**
     * Set Tulipa_Model_Crud::$_id
     *
     * @param int $id
     * @return Tulipa_Model_Crud
     */
    public function setId($id = null)
    {
        $this->_id = (null === $id) ? null : (int) $id;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Tulipa_Model_Crud::$_where
     *
     * @param array $where
     * @return Tulipa_Model_Crud
     */
    public function setWhere($where = null)
    {
        $this->_where = (null === $where) ? null : (array) $where;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_where
     *
     * @return array
     */
    public function getWhere()
    {
        return $this->_where;
    }

    /**
     * Set Tulipa_Model_Crud::$_having
     *
     * @param array $having
     * @return Tulipa_Model_Crud
     */
    public function setHaving($having = null)
    {
        $this->_having = (null === $having) ? null : (array) $having;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_having
     *
     * @return array
     */
    public function getHaving()
    {
        return $this->_having;
    }

    /**
     * Set Tulipa_Model_Crud::$_order
     *
     * @param string $order
     * @return Tulipa_Model_Crud
     */
    public function setOrder($order = null)
    {
        $this->_order = (null === $order) ? null : (string) $order;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * Set Tulipa_Model_Crud::$_limit
     *
     * @param int $limit
     * @return Tulipa_Model_Crud
     */
    public function setLimit($limit = null)
    {
        $this->_limit = (null === $limit) ? null : (int) $limit;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * Set Tulipa_Model_Crud::$_group
     *
     * @param string $group
     * @return Tulipa_Model_Crud
     */
    public function setGroup($group = null)
    {
        $this->_group = (null === $group) ? null : (string) $group;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_group
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->_group;
    }
        
    /**
     * Add to Tulipa_Model_Crud::$_subModules
     *
     * @param string $subModule
     * @return Tulipa_Model_Crud
     */
    public function addSubModule($subModule)
    {
        $this->_subModules[] = $subModule;
        return $this;
    }

    /**
     * Set Tulipa_Model_Crud::$_subModules
     *
     * @param array $subModules
     * @return Tulipa_Model_Crud
     */
    public function setSubModules($subModules = null)
    {
        $this->_subModules = (null === $subModules) ? null : (array) $subModules;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_subModules
     *
     * @return array
     */
    public function getSubModules()
    {
        return $this->_subModules;
    }

    /**
     * Set Tulipa_Model_Crud::$_crudConfig(object)
     *
     * @param mixed $crudConfig(object)
     * @return Tulipa_Model_Crud
     */
    public function setCrudConfig($crudConfig = null)
    {
        $this->_crudConfig = $crudConfig;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_crudConfig(object)
     *
     * @return mixed
     */
    public function getCrudConfig()
    {
        return $this->_crudConfig;
    }

    /**
     * Set Tulipa_Model_Crud::$_extraModel
     *
     * @param Tulipa_Model_Crud_Extra_Interface $extraModel
     * @return Tulipa_Model_Crud
     */
    public function setExtraModel(Tulipa_Model_Crud_Extra_Interface $extraModel = null)
    {
        $this->_extraModel = $extraModel;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud::$_extraModel
     *
     * @return Tulipa_Model_Crud_Extra_Interface
     */
    public function getExtraModel()
    {
        return $this->_extraModel;
    }
    
    /**
     * Get Zend_Db_Table object from the mapper.
     * 
     * @return Zend_Db_Table
     */
    public function getDbtable()
    {
        return $this->getMapper()->getDbTable();
    }
    
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse($this, $returnArray);
    }
    
    public function read()
    {
        if (isset($this->_extraModel)) {
            $this->_extraModel->onBeforeRead();
        }
        
        $row = $this->getMapper()->read($this);
    
        if (isset($this->_extraModel)) {
            $this->_extraModel->onAfterRead($row);
        }
        return $row;
    }
    
    /**
     * Read row but return the Zend_Db_Select object.
     * 
     * @return Zend_Db_Select
     */
    public function readWithSelect()
    {
        $select = $this->getMapper()->read($this, false);
        return $select;
    }
    
    /**
     * Read row but return the Zend_Db_Select object.
     * 
     * @return Zend_Db_Table_Row_Abstract|null
     */
    public function readLast()
    {
        $select = $this->getMapper()->read($this, false);
        $orderByColumn = 'default.' . $this->getPrimaryKeyColumn();
        $select->order($orderByColumn . ' DESC');
        return $this->getDbtable()->fetchRow($select);
    }
    
    public function update()
    {    
        if (isset($this->_extraModel)) {
            $this->_extraModel->onBeforeUpdate();
        }
        
    	$this->getMapper()->update($this);
    	
        if (isset($this->_extraModel)) {
            $this->_extraModel->onAfterUpdate();
        }
        
        return $this;
    }
    
    /**
     * @see Application_Bread_Interface::insert()
     * @return integer Last insert id
     */
    public function insert()
    {
        if (isset($this->_extraModel)) {
            $this->_extraModel->onBeforeInsert();
        }
        
        $id = $this->getMapper()->insert($this);
        
        if (isset($this->_extraModel)) {
            $this->_extraModel->onAfterInsert($id);
        }
        
        return $id;
    }
    
    public function delete()
    {
        if (isset($this->_extraModel)) {
            $this->_extraModel->onBeforeDelete();
        }
        
        $this->getMapper()->delete($this);
        
        if (isset($this->_extraModel)) {
            $this->_extraModel->onAfterDelete();
        }
        
        return $this;
    }
    
    /**
     * Get items ready for selectmenu.
	 * 
     * @param string  $indexColumn
     * @param string  $labelColumn
     * @param boolean $includeNullItem
     * @return array\
     * @throws Zend_Exception When $labelColumn or $indexColumn is not set
     */
    public function browseForMultiOptions($indexColumn = 'id', $labelColumn, 
        $includeNullItem = false, $nested = false, $parentColumnName = 'parentId', 
        $parentId = null)
    {
        if (empty($labelColumn) || empty($indexColumn)) {
            throw new Zend_Exception('$labelColumn or $indexColumn is not set');
        }
        
        $select = $this->browse(false);
        
        if ($nested) {
            $select->joinLeft(array('child' => $this->getDbTableName()), 
                				  '`child`.`' . $parentColumnName 
                                  . '` = `default`.`' . $this->getPrimaryKeyColumn() . '`',
                                  array(
                                      new Zend_Db_Expr('(COUNT(`child`.`' . $this->getPrimaryKeyColumn() . '`) > 0) AS `hasChildren`'),
                                      'default.' . $parentColumnName . ''));
            
            if (empty($parentId)) {
                $select->where('default.' . $parentColumnName . ' IS NULL');
            } else {
                $select->where('default.' . $parentColumnName . ' = ?', $parentId, 'INTEGER');
            }        
            
            $select->group('default.' . $this->getPrimaryKeyColumn());
            
        }
                        
        $rows = $this->getDbTable()->fetchAll($select);
        
        $items = array();
        
        if ($includeNullItem) {
            $items[null] = '-';
        }
                
        if (null !== $rows) {
            foreach ($rows as $row) {
                $items[$row->$indexColumn] = $row->$labelColumn;
                
                if ($nested) {
                    $hasChildren = (int) $row->hasChildren;                    
                    if ($hasChildren) {
                        $items[$row->$labelColumn . ':'] = 
                            $this->browseForMultiOptions($indexColumn, $labelColumn, false, true, 
                                                        $parentColumnName, $row->$indexColumn);
                    }
                }
            }
        }
        
        return $items;
    }
}
