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
 * @subpackage PagesArticles
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Settings.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Articles tagging model.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage PagesArticles
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_PagesArticles_Search
{
    /**
     * DB Table class name.
     * @var string
     */
    const DB_TABLE = 'Default_Model_DbTable_ArticlesSearch';
    
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    
    /**
     * Create DB Table instance.
     * 
     * @param Zend_Db_Table_Abstract|string $dbTable
     * @throws Exception
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    /**
     * Get DB Table instance.
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable(self::DB_TABLE);
        }
        return $this->_dbTable;
    }
    
    /**
     * Search articles.
     * 
     * @param string 	$keyword
     * @param boolean 	$returnSelectObject Return Zend_Db_Select 
     * 										object (used in Zend_Paginator)
     * @return Zend_Db_Table_Rowset|Zend_Db_Select|null
     */
    public function search($keyword, $returnSelectObject = true)
    {
        $dbTable = $this->getDbTable();
        $dbAdapter = $dbTable->getAdapter();
        
        $keyword = trim(strip_tags($keyword));
        if (empty($keyword)) {
            return;
        }
        
        $select = $dbTable->select()->from($dbTable, array(
            '*', 
    		'MATCH (`content`,`intro`,`title`) AGAINST (' . $dbAdapter->quote($keyword) 
                                                          . ') AS perc',
            'DATE(`date`) AS shortDate'
        ));
        $select->having('`perc`')->order('perc DESC');
        
        if ($returnSelectObject) {
            return $select;
        }
        
        return $dbTable->fetchAll($select);
    }
}