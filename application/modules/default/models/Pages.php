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
 * @subpackage Pages
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Settings.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Pages model.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage Pages
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_Pages
{
    
    /**
     * DB Table class name.
     * @var string
     */
    const DB_TABLE = 'Default_Model_DbTable_Pages';
    
    const ROUTE_PAGE_ID = 'page-id';
    const ROUTE_PAGE_URL = 'page-url';
    
    const PAGE_CONTROLLER = 'articles';
    const PAGE_ACTION = 'index';
    
    const INDEX_LABEL = 'Начало';
    const INDEX_ROUTE = 'default';
    const INDEX_CONTROLLER = 'index';
    const INDEX_ACTION = 'index';
    
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    
    /**
     * @var array
     */
    protected $_indexPageSettings = array(
        'label' => self::INDEX_LABEL,
    	'route' => self::INDEX_ROUTE,
    	'controller' => self::INDEX_CONTROLLER,
        'action' => self::INDEX_ACTION
    );
    
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
     * Get navigation pages (recursively with subpages) compatible 
     * for Zend_Navigation_Container.
     * 
     * @param int|null $parentId
     * @return array|null
     */
    protected function _getNavigationPagesRecursive($parentId = null)
    {
        // If parent id is null, select only top level pages
        if (empty($parentId)) {
            $whereCond = 'parentId IS NULL';
        } else {
            $whereCond = array('parentId = ?' => $parentId);
        }
        
        $pages = $this->getDbTable()->fetchAll($whereCond, 'position');
        
        if (empty($pages)) {
            return null;
        }
        
        // Create Zend_Navigation_Container array
        $items = array();
        foreach ($pages as $page)
        {
            if (empty($page->url)) {
                $params = array('id' => $page->id);
                $route = self::ROUTE_PAGE_ID;
            } else {
                $params = array('url' => $page->url);
                $route = self::ROUTE_PAGE_URL;
            }
            
            $subPages = $this->_getNavigationPagesRecursive($page->id);
            
            /*
             * We have to add the current iteration page as a subpage
             * to trace active page.
             */
            if (!empty($subPages)) {
                $subPages[] = array(
                    'label' => $page->title,
                    'route' => $route,
                    'controller' => self::PAGE_CONTROLLER,
                    'action' => self::PAGE_ACTION,
                    'params' => $params,
                	'class' => 'hidden'
                );
            }
            
            $items[] = array(
                'label' => $page->title,
                'route' => $route,
                'controller' => self::PAGE_CONTROLLER,
                'action' => self::PAGE_ACTION,
                'params' => $params,
  				'pages' => $subPages
            );
        }
        return $items;
    }
    
    /**
     * Get Zend_Navigation_Container compatible
     * array with site pages.
     * 
     * @param boolean $includeIndexPage Include index link in the begining
     * 									of the array.
     * @return array
     */
    public function getNavigation($includeIndexPage = true)
    {
        $items = $this->_getNavigationPagesRecursive();
        $items = empty($items) ? array() : $items;
        
        if ($includeIndexPage) {
            array_unshift($items, $this->_indexPageSettings);
        }
        
        return $items;
    }
    
    /**
     * Get subpages.
     * 
     * @param int $id
     * @return null|array
     */
    public function getPageChildren($id)
    {
        return $this->getDbTable()->fetchAll(array('parentId = ?' => $id));
    }
    
    /**
     * Get subpages.
     * 
     * Get only IDs.
     * 
     * @param int $id
     * @param boolean $includeParentId
     * @return null|array
     */
    public function getPageChildrenIds($id, $includeParentId = false)
    {
        $pages = $this->getPageChildren($id);
        if (empty($pages)) {
            if ($includeParentId) {
                return array($id);
            }
            return null;
        }
        
        $subPages = array();
        
        if ($includeParentId) {
            $subPages[] = $id;
        }
        
        foreach ($pages as $page) 
        {
            $subPages[] = $page->id;
        }

        return $subPages;
    }
    
    /**
     * Static method. 
     * Proxies to {@see getPageChildren()}
     * @return null|array
     */
    public static function getPageChildrenIdsStatic($id, $includeParentId = false)
    {
        $model = new self;
        return $model->getPageChildrenIds($id, $includeParentId);
    }
    
    /**
     * Get page details.
     * 
     * @param string|int 	$url 	If $url is integer, will use it as page id.
     * 							 	If it's array, will try to use keys url or id
     * 							 	for selection.
     * @param int|boolean	$id		If $id is boolean, it will be accepted as $getWithChildren
     * @param boolean 		$getWithChildren
     * @param boolean 		$includeParentId
     * @return array|null
     */
    public function getPageDetails($url, $id = null, $getWithChildren = true, $includeParentId = false)
    {
        if (empty($url) && empty($id)) {
            return;
        }
        
        if (is_int($url) && (empty($id) || is_bool($id))) {
            $id = $url;
            unset($url);
        }
        
        if (is_array($url)) {
            $params = $url;
            if (isset($params['id'])) {
                $id = $params['id'];
            }
            
            if (isset($params['url'])) {
                $url = $params['url'];
            }
            unset($params);
        }
        
        if (is_bool($id)) {
            $getWithChildren = $id;
            unset($id);
        }
        
        if (isset($url)) {
            $whereCond = array('url = ?' => $url);
        } else if (isset($id)) {
            $whereCond = array('id = ?' => $id);            
        } else {
            return;
        }
        
        $page = $this->getDbTable()->fetchRow($whereCond);
        
        // Get page subpages
        if (null != $page && $getWithChildren) {
            $page = $page->toArray();
            $page['children'] = $this->getPageChildrenIds($page['id'], $includeParentId);
        }
        
        return $page;
    }
    
    /**
     * Static method. 
     * Proxies to {@see getPageDetails()}
     * 
     * @return array|null
     */
    public static function getPageDetailsStatic($url, $id = null, $getWithChildren = true)
    {
        $model = new self;
        return $model->getPageDetails($url, $id, $getWithChildren);
    }
}