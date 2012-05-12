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
 * @package    Tulipa_Forms
 * @subpackage Elements
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: SelectMenuDb.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Select menu element, that gets the menu items from the database.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Elements
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Form_Element_SelectMenuDb extends Zend_Form_Element_Select
{
    
	/**
     * @var array
     */
    protected $_table = null;

    /**
     * @var array
     */
    protected $_lang = array('enabled' => false);
    
    /**
     * @var boolean
     */
    protected $_includeNullItem = false;
    
    /**
     * @var string
     */
    protected $_parentColumnName = 'parentId';
    
    /**
     * @var boolean
     */
    protected $_nested = false;
    
    /**
     * Set Application_Form_Element_SelectMenuDb::$_table
     *
     * @param array $table
     * @return Application_Form_Element_SelectMenuDb
     */
    public function setTable($table = null)
    {
        $this->_table = (null === $table) ? null : (array) $table;
        return $this;
    }

    /**
     * Get Application_Form_Element_SelectMenuDb::$_table
     *
     * @return array
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Set Application_Form_Element_SelectMenuDb::$_lang
     *
     * @param array $lang
     * @return Application_Form_Element_SelectMenuDb
     */
    public function setLang($lang = null)
    {
        $this->_lang = (null === $lang) ? null : (array) $lang;
        return $this;
    }

    /**
     * Get Application_Form_Element_SelectMenuDb::$_lang
     *
     * @return array
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * Set Application_Form_Element_SelectMenuDb::$_includeNullItem
     *
     * @param boolean $includeNullItem
     * @return Application_Form_Element_SelectMenuDb
     */
    public function setIncludeNullItem($includeNullItem = false)
    {
        $this->_includeNullItem = (null === $includeNullItem) ? null : (boolean) $includeNullItem;
        return $this;
    }

    /**
     * Get Application_Form_Element_SelectMenuDb::$_includeNullItem
     *
     * @return boolean
     */
    public function getIncludeNullItem()
    {
        return $this->_includeNullItem;
    }

    /**
     * Set Application_Form_Element_SelectMenuDb::$_parentColumnName
     *
     * @param string $parentColumnName
     * @return Application_Form_Element_SelectMenuDb
     */
    public function setParentColumnName($parentColumnName = null)
    {
        $this->_parentColumnName = $parentColumnName;
        return $this;
    }

    /**
     * Get Application_Form_Element_SelectMenuDb::$_parentColumnName
     *
     * @return string
     */
    public function getParentColumnName()
    {
        return $this->_parentColumnName;
    }

    /**
     * Set Application_Form_Element_SelectMenuDb::$_nested
     *
     * @param boolean $nested
     * @return Application_Form_Element_SelectMenuDb
     */
    public function setNested($nested = false)
    {
        $this->_nested = (boolean) $nested;
        return $this;
    }

    /**
     * Get Application_Form_Element_SelectMenuDb::$_nested
     *
     * @return boolean
     */
    public function getNested()
    {
        return $this->_nested;
    }
    
    /**
     * Add multiselect options from the database.
     * 
     * @return void
     * @see Zend_Form_Element::init()     * 
     */
    public function init()
    {
        $tableOptions = $this->getTable();
        $langOptions = $this->getLang();
        
        $crudModel = new Tulipa_Model_Crud(array(
            'table' => $tableOptions['table']
        ));
        
        if (isset($tableOptions['labelColumn'])) {
            $crudModel->setColumnsForSelect(array($tableOptions['labelColumn']));
        }
        
        if (isset($tableOptions['primaryKeyColumn'])) {
            $crudModel->setPrimaryKeyColumn($tableOptions['primaryKeyColumn']);
        }
        
        if ($langOptions['enabled']) {            
            $labelColumn = $langOptions['labelColumn'];
            // We need only primary key column in the main select
            $crudModel->setColumnsForSelect(array());
            
            $langModel = new Tulipa_Model_Crud_Lang(array(
                'table' => $langOptions['table'],
                'columnsForSelect' => array($langOptions['labelColumn'])
            ));
            
            if (isset($langOptions['primaryKeyColumn'])) {
                $langModel->setPrimaryKeyColumn($langOptions['primaryKeyColumn']);
            }
            
            $crudModel->setLangModel($langModel);
        } else {            
            $labelColumn = $tableOptions['labelColumn'];
        }
                
        $this->setMultiOptions(
            $crudModel->browseForMultiOptions(
                $crudModel->getPrimaryKeyColumn(), 
                $labelColumn,
                $this->getIncludeNullItem(),
                $this->getNested(),
                $this->getParentColumnName()
            )
        );
    }
    
}
