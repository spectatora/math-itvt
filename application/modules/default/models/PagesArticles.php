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
 * Articles model.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage PagesArticles
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_PagesArticles
{
    
    /**
     * DB Table class name.
     * @var string
     */
    const DB_TABLE = 'Default_Model_DbTable_PagesArticles';
    
    /**
     * DB View class name.
     * @var string
     */
    const DB_VIEW = 'Default_Model_DbTable_PagesArticles_View';
    
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbView;
    
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
     * Create DB View instance.
     * 
     * @param Zend_Db_Table_Abstract|string $dbView
     * @throws Exception
     */
    public function setDbView($dbView)
    {
        if (is_string($dbView)) {
            $dbView = new $dbView();
        }
        if (!$dbView instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid table data gateway provided');
        }
        $this->_dbView = $dbView;
        return $this;
    }
 
    /**
     * Get DB View instance.
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbView()
    {
        if (null === $this->_dbView) {
            $this->setDbView(self::DB_VIEW);
        }
        return $this->_dbView;
    }
    
    /**
     * Get last submitted articles.
     * 
     * @param int|array|null	$pageId
     * @param int 				$limit
     * @param boolean			$withPicturesOnly Get only the articles with pictures
     * @param boolean			$strict 		  If true - get only with specified ID.	
     * @return Zend_Db_Table_Rowset|null
     */
    public function getTopArticles($pageId = null, $limit = 4, $withPicturesOnly = true, $strict = false)
    {
        $dbTable = $this->getDbView();
        $select = $dbTable->select()->group('id')->order('date DESC');
        
        if (isset($limit)) {
            $select->limit($limit);
        }
        
        if ($withPicturesOnly) {
            $select->where('picture IS NOT NULL');
        }
        
        if (!empty($pageId)) {
            if (is_array($pageId)) {
                $select->where('pageId IN (' . implode(',', $pageId) . ')');
            } else {
                $select->where('pageId = ?', $pageId, 'INTEGER');
            }
        } else {
            if ($strict) {
                return;
            }
        }
        
        return $dbTable->fetchAll($select);
    }
    
    /**
     * Get only IDs from articles.
     * 
     * @param Zend_Db_Table_Rowset $rowset
     * @return Array
     */
    public static function getOnlyIDs($rowset)
    {
        $ids = array();        
        if (!empty($rowset)) {
            foreach ($rowset as $row)
            {
                $ids[] = $row->id;
            }
        }
        
        return $ids;
    }
    
    /**
     * Browse articles.
     * 
     * @param int|array $pageId		If array - will select articles from the given
     * 								page IDs
     * @param boolean 	$useView 	Use view instead of table.
     * @param array 	$exlude		Articles to exlude from selection
     * @param int	 	$limit
     * @param boolean	$strict 	If true - get only with specified ID.
     * @return Zend_Db_Table_Rowset|Zend_Db_Table_Select|null
     */
    public function getArticles($pageId = null, $useView = false, $exlude = null, 
                                $limit, $returnDbSelectObject = false, $strict = false)
    {
        if ($useView) {
            $dbTable = $this->getDbView();
        } else {
            $dbTable = $this->getDbTable();
        }
        
        $select = $dbTable->select()->from($dbTable, array(
            '*', 'DATE(`date`) AS shortDate'
        ));
        
        if (!empty($pageId)) {
            if (is_array($pageId)) {
                $select->where('pageId IN (' . implode(',', $pageId) . ')');
            } else {
                $select->where('pageId = ?', $pageId, 'INTEGER');
            }
        } else {
            if ($strict) {
                return;
            }
        }
        
        if (!empty($exlude)) {
            if (is_array($exlude)) {
                $select->where('id NOT IN (' . implode(',', $exlude) . ')');
            } else {
                $select->where('id != ?', $exlude, 'INTEGER');
            }
        }
        
        if (!empty($limit)) {
            $select->limit($limit);
        }
        
        $select->order('date DESC')->group('id');
        
        if ($returnDbSelectObject) {
            return $select;
        }
        
        return $dbTable->fetchAll($select);
    }
    
    /**
     * Get the most popular articles. 
     * 
     * Order by views count.
     * 
     * @param array|int|null 	$pageId
     * @param int 				$limit
     * @return Zend_Db_Table_Rowset|null
     */
    public function getMostPopularArticles($pageId, $limit)
    {
        $dbTable = $this->getDbView();
        
        $select = $dbTable->select()->from($dbTable, array(
            '*', 'COUNT(`viewId`) AS viewCount'
        ));
        $select->group('id')->limit($limit)->order('viewCount DESC');
        
        if (!empty($pageId)) {
            if (is_array($pageId)) {
                $select->where('pageId IN (' . implode(',', $pageId) . ')');
            } else {
                $select->where('pageId = ?', $pageId, 'INTEGER');
            }
        }
        
        return $dbTable->fetchAll($select);
    }
    
    /**
     * Get single article by url and date or id.
     * 
     * @param string|int 	$url 	If $url is integer, will use it as article id.
     * @param string 		$date
     * @param int 			$id
     * @return Zend_Db_Table_Row_Abstract
     */
    public function getArticleDetails($url, $date, $id = null)
    {
        $dbTable = $this->getDbView();
        
        if (empty($url) && empty($id) && empty($date)) {
            return;
        }
        
        if (is_int($url)) {
            $id = $url;
            unset($url, $date);
        }
        
        if (isset($url) && isset($date)) {
            unset($id);
        }
        
        $select = $dbTable->select()->from($dbTable, array(
        	'*', 
            new Zend_Db_Expr('NULL AS `pictures`'), 
            new Zend_Db_Expr('NULL AS `tags`')
        ));
                
        if (isset($url) && isset($date)) {
            $select->where('url = ?', $url, 'STRING')
                   ->where('shortDate = ?', $date, 'STRING');
        } else if (isset($id)) {
            $select->where('id = ?', $id, 'INTEGER');     
        } else {
            return;
        }
        
        $article = $dbTable->fetchRow($select);
                
        // Get gallery and tags
        if (null !== $article) {
            $article->pictures = self::getGallery($article->id);
            $article->tags = self::getTags($article->id);
        }
                
        return $article;
    }
    
    /**
     * Get articles by tag name.
     * 
     * @param 	string 		$tag
     * @param 	boolean 	$returnDbSelectObject
     * @return 	Zend_Db_Table_Rowset_Abstract|Zend_Db_Select|null
     */
    public static function getByTag($tag, $returnDbSelectObject = true)
    {
        $tag = trim(strip_tags($tag));
        if (empty($tag)) {
            return;
        }
        
        $tagsDBTable = new Default_Model_DbTable_PagesArticles_TagsView;
        $select = $tagsDBTable->select()
                              ->where('tag = ?', $tag, 'STRING')
                              ->group('articleId')
                              ->order('date DESC')
                              ->limit(10);
                              
        if ($returnDbSelectObject) {
            return $select;
        }
        
        return $tagsDBTable->fetchAll($select);
    }
    
    /**
     * Get similar articles by tags.
     * 
     * @param Zend_Db_Table_Rowset 	$tags 		Common tags
	 * @param int					$excludeId	Article ID to exclude from selection
	 * @param int					$limit
     * @return Zend_Db_Table_Rowset_Abstract|null
     */
    public static function getSimilarArticles($tags, $excludeId, $limit)
    {
        $tagsDBTable = new Default_Model_DbTable_PagesArticles_TagsView;
        $select = $tagsDBTable->select()
                              ->from($tagsDBTable, array('*', 'COUNT(`articleId`) AS perc'))
                              ->group('articleId')
                              ->order('date DESC')
                              ->order('perc DESC')
                              ->limit(10);
                           
        foreach ($tags as $tag)
        {
            $select->orWhere('tag = ?', $tag->tag, 'STRING');
        }
        
        if (!empty($excludeId)) {
            $select->having('id != ?', $excludeId, 'INTEGER');
        }
        
        if (!empty($limit)) {
            $select->limit($limit);
        }
        
        return $tagsDBTable->fetchAll($select);
    }
    
    /**
     * Get pictures by article id.
     * 
     * Proxies to {@see Default_Model_PagesArticles_Pictures::getGallery()}
     * 
     * @param int $articleId
     * @return Zend_Db_Table_Rowset_Abstract|null
     */
    public static function getGallery($articleId)
    {
        return Default_Model_PagesArticles_Pictures::getGallery($articleId);
    }
    
    /**
     * Get tags by article id.
     * 
     * Proxies to {@see Default_Model_PagesArticles_Tags::getTags()}
     * 
     * @param int $articleId
     * @return Zend_Db_Table_Rowset_Abstract|null
     */
    public static function getTags($articleId)
    {
        return Default_Model_PagesArticles_Tags::getTags($articleId);
    }
    
    /**
     * Increase article view count by 1.
     * 
     * @param int $id
     */
    public static function updateArticleViewsCount($id)
    {
        $sql = 'INSERT IGNORE INTO `pages_articles_views` (`articleId`, `ip`) VALUES (?, ?)';
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $dbAdapter->query($sql, array(
            $id, $_SERVER['REMOTE_ADDR']
        ));
    }
}