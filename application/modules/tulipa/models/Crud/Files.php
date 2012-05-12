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
 * @version    $Id: Files.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD files model.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Crud_Files extends Tulipa_Model_Abstract
                              implements Application_Bread_Interface
{
    
    /**
     * Name of the DB Table to use.
     * 
     * @var string
     */
    protected $_table = null;

    /**
     * Primary key(id) column.
     * 
     * @var string
     */
    protected $_primaryKeyColumn = 'id';

    /**
     * Foregn key column that references to the 
     * modules DB Table primary key.
     * 
     * @var string
     */
    protected $_parentColumn = 'parentId';

    /**
     * Column that cointains the filename.
     * 
     * @var string
     */
    protected $_filenameColumn = 'filename';

    /**
     * @var int
     */
    protected $_parentId = null;

    /**
     * Files to add
     * 
     * @var array
     */
    protected $_files = null;
    
    /**
     * @var int
     */
    protected $_id = null;
    
    /**
     * @var string
     */
    protected $_url = null;
    
    /**
     * @var string
     */
    protected $_thumbsFolder = 'thumbs';
    
    /**
     * @var string
     */
    protected $_destination = null;

    /**
     * Set Tulipa_Model_Crud_Files::$_table
     *
     * @param string $table
     * @return Tulipa_Model_Crud_Files
     */
    public function setTable($table = null)
    {
        $this->_table = (null === $table) ? null : (string) $table;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_primaryKeyColumn
     *
     * @param string $primaryKeyColumn
     * @return Tulipa_Model_Crud_Files
     */
    public function setPrimaryKeyColumn($primaryKeyColumn = 'id')
    {
        $this->_primaryKeyColumn = (null === $primaryKeyColumn) ? null : (string) $primaryKeyColumn;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_primaryKeyColumn
     *
     * @return string
     */
    public function getPrimaryKeyColumn()
    {
        return $this->_primaryKeyColumn;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_parentColumn
     *
     * @param string $parentColumn
     * @return Tulipa_Model_Crud_Files
     */
    public function setParentColumn($parentColumn = 'parentId')
    {
        $this->_parentColumn = (null === $parentColumn) ? null : (string) $parentColumn;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_parentColumn
     *
     * @return string
     */
    public function getParentColumn()
    {
        return $this->_parentColumn;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_filenameColumn
     *
     * @param string $filenameColumn
     * @return Tulipa_Model_Crud_Files
     */
    public function setFilenameColumn($filenameColumn = 'filename')
    {
        $this->_filenameColumn = (null === $filenameColumn) ? null : (string) $filenameColumn;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_filenameColumn
     *
     * @return string
     */
    public function getFilenameColumn()
    {
        return $this->_filenameColumn;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_parentId
     *
     * @param int $parentId
     * @return Tulipa_Model_Crud_Files
     */
    public function setParentId($parentId = null)
    {
        $this->_parentId = (null === $parentId) ? null : (int) $parentId;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->_parentId;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_files
     *
     * @param array $files
     * @return Tulipa_Model_Crud_Files
     */
    public function setFiles($files = null)
    {
        $this->_files = (null === $files) ? null : (array) $files;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_files
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->_files;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_id
     *
     * @param int $id
     * @return Tulipa_Model_Crud_Files
     */
    public function setId($id = null)
    {
        $this->_id = (null === $id) ? null : (int) $id;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_url
     *
     * @param string $url
     * @return Tulipa_Model_Crud_Files
     */
    public function setUrl($url = null)
    {
        $this->_url = (null === $url) ? null : (string) $url;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_thumbsFolder
     *
     * @param string $thumbsFolder
     * @return Tulipa_Model_Crud_Files
     */
    public function setThumbsFolder($thumbsFolder)
    {
        $this->_thumbsFolder = (null === $thumbsFolder) ? null : (string) $thumbsFolder;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_thumbsFolder
     *
     * @return string
     */
    public function getThumbsFolder()
    {
        return $this->_thumbsFolder;
    }

    /**
     * Set Tulipa_Model_Crud_Files::$_destination
     *
     * @param string $destination
     * @return Tulipa_Model_Crud_Files
     */
    public function setDestination($destination = null)
    {
        $this->_destination = (null === $destination) ? null : (string) $destination;
        return $this;
    }

    /**
     * Get Tulipa_Model_Crud_Files::$_destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->_destination;
    }
    
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
     * This method is not available
     * 
     * @see Application_Bread_Interface::update()
     * @throws Zend_Exception This method 
     * 						  is not available for this model
     */
    public function update()
    {
        throw new Zend_Exception('Method update() not available for this model');
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
    
    public function read()
    {
        return $this->getMapper()->read($this);
    }
    
    public function delete()
    {        
        $this->getMapper()->delete($this);
        return $this;
    }
}