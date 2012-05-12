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
 * @subpackage Notifications
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Lang.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD multilingual model.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Crud_Lang extends Tulipa_Model_Abstract
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
     * @var string
     */
    protected $_parentColumn = 'parentId';

    /**
     * @var string
     */
    protected $_langColumn = 'langId';
    
    /**
     * Data for insert/update.
     * 
     * @var array
     */
    protected $_data = null;
    
    /**
     * @var int
     */
    protected $_parentId = null;

    /**
     * @var int
     */
    protected $_langId = null;
    
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
     * @param Tulipa_Model_Crud $langModel
     * @return Tulipa_Model_Crud
     */
    public function setLangModel(Tulipa_Model_Crud $langModel = null)
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
     * @return Tulipa_Model_Crud
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
     * Set Tulipa_Model_Crud_Lang::$_parentColumn
     *
     * @param string $parentColumn
     * @return Tulipa_Model_Crud_Lang
     */
    public function setParentColumn($parentColumn = null)
    {
        $this->_parentColumn = (null === $parentColumn) ? null : (string) $parentColumn;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Lang::$_parentColumn
     *
     * @return string
     */
    public function getParentColumn()
    {
        return $this->_parentColumn;
    }

    /**
     * Set Tulipa_Model_Crud_Lang::$_langColumn
     *
     * @param string $langColumn
     * @return Tulipa_Model_Crud_Lang
     */
    public function setLangColumn($langColumn = null)
    {
        $this->_langColumn = (null === $langColumn) ? null : (string) $langColumn;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Lang::$_langColumn
     *
     * @return string
     */
    public function getLangColumn()
    {
        return $this->_langColumn;
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
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Set Tulipa_Model_Crud_Lang::$_parentId
     *
     * @param int $parentId
     * @return Tulipa_Model_Crud_Lang
     */
    public function setParentId($parentId = null)
    {
        $this->_parentId = (null === $parentId) ? null : (int) $parentId;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Lang::$_parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->_parentId;
    }

    /**
     * Set Tulipa_Model_Crud_Lang::$_langId
     *
     * @param int $langId
     * @return Tulipa_Model_Crud_Lang
     */
    public function setLangId($langId = null)
    {
        $this->_langId = (null === $langId) ? null : (int) $langId;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Lang::$_langId
     *
     * @return int
     */
    public function getLangId()
    {
        return $this->_langId;
    }
    
    public function update()
    {
    	$this->getMapper()->update($this);
        return $this;
    }
    
    public function insert()
    {
        $this->getMapper()->insert($this);
        return $this;
    }
    
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse($this, $returnArray);
    }
    
    /**
     * Browse translations ready for form.
     * 
     * @return array
     */
    public function browseForForm()
    {
        $translations = $this->browse(true);
        $readyForForm = array();
        
        foreach ($translations as $translation)
        {
            $langId = $translation[$this->getLangColumn()];
            $readyForForm[$translation[$this->getLangColumn()]] = $translation;
            unset($readyForForm[$langId][$this->getLangColumn()],
                  $readyForForm[$langId][$this->getParentColumn()]);
        }
        
        return $readyForForm;
    }
    
    public function read()
    {        
    }
    
    public function delete()
    {        
    }
}