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
 * @subpackage Settings
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Settings.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * CRUD plugin model for articles system.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_Crud_Articles extends Tulipa_Model_Crud_Extra_Abstract
{
    /**
     * DB Table name.
     * @var string
     */
    protected $_dbTableName = 'pages_articles_fulltext';
    
    /**
     * @var Application_Db_Table
     */
    protected $_dbTable = null;
    
    /**
     * We temporary save keywords here.
     * @var string
     */
    protected $_keywords = null;

    /**
     * Set Default_Model_Crud_Articles::$_dbTable
     *
     * @param Zend_Db_Table_Abstract $dbTable
     * @return Default_Model_Crud_Articles
     */
    public function setDbTable(Zend_Db_Table_Abstract $dbTable = null)
    {
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Get Default_Model_Crud_Articles::$_dbTable
     *
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (empty($this->_dbTable)) {
            $this->setDbTable(new Application_Db_Table($this->_dbTableName));
        }
        return $this->_dbTable;
    }
    
    /**
     * Update article's keywords.
     * 
     * @param int $articleId
     * @return void
     */
    public function _updateKeywords($articleId)
    {
        if (empty($this->_keywords) || empty($articleId)) {
            return;
        }
        
        // Delete old tags
        $dbTable = new Default_Model_DbTable_PagesArticlesTags();
        $dbTable->delete(array('articleId = ?' => $articleId));
        
        $keywords = explode(',', $this->_keywords);
        foreach ($keywords as $keyword)
        {
            $keyword = trim($keyword);
            if (!empty($keyword)) {
                $insertSql = 'INSERT IGNORE INTO `pages_articles_tags` ' 
                             . '(`tag`, `articleId`) VALUES (:tag, :id)';
                $dbTable->getAdapter()
                        ->query($insertSql, array(
                        	':tag' => $keyword,
                            ':id' => $articleId
                        ));
            }
        }
    }
    
    /**
     * Get keywords.
     * @see Tulipa_Model_Crud_Extra_Abstract::onAfterRead()
     */
    public function onAfterRead(&$row)
    {
        $id = $row['id'];
        
        $dbTable = new Default_Model_DbTable_PagesArticlesTags();
        $keywords = $dbTable->fetchAll(array(
        	'articleId = ?' => $id
        ));
        
        if (!empty($keywords)) {
            $keywordsPieces = array();
            foreach ($keywords as $keyword)
            {
                $keywordsPieces[] = $keyword['tag'];
            }
            $row['keywordsArray'] = $keywordsPieces;
            $row['keywords'] = implode(',', $keywordsPieces);
        }
    }
    
    /**
     * Insert default values for metaTitle and metaDescription and
     * remove keywords from data to insert in pages_articles.
     *  
     * @see Tulipa_Model_Crud_Extra_Abstract::onBeforeInsert()
     */
    public function onBeforeInsert()
    {
       // auto fill meta fields
       $data = $this->getModel()->getData();
       
       if (empty($data['metaTitle'])) {
           $data['metaTitle'] = $data['title'];
       } 
       
       if (empty($data['metaDescription'])) {
           $data['metaDescription'] = $data['intro'];
       }
       
       if (isset($data['keywords'])) {
           // Remove keywords from data to insert in pages_articles
           $this->_keywords = $data['keywords'];
           unset($data['keywords']);
       }
       
       $this->getModel()->setData($data);
    }
    
    /**
     * Synchronize pages_articles table with pages_articles_fulltext
     * on insert and update keywords.
     * 
     * @see Tulipa_Model_Crud_Extra_Abstract::onAfterInsert()
     */
    public function onAfterInsert($id)
    {
        $data = $this->getModel()->getData();
        $dbTable = $this->getDbTable();
        
        $dbTable->insert(array(
            'title' => $data['title'],
            'intro' => $data['intro'],
            'url' => $data['url'],
            'picture' => isset($data['picture']) ? $data['picture'] : $data['picture'],
            'content' => strip_tags($data['content']),
            'articleId' => $id,
            'pageId' => $data['pageId']
        ));
        
        // Update keywords
        $this->_updateKeywords($id);
    }
    
    /**
     * Remove keywords from data to insert in pages_articles
     * @see Tulipa_Model_Crud_Extra_Abstract::onBeforeUpdate()
     */
    public function onBeforeUpdate()
    {
       $data = $this->getModel()->getData();
       if (isset($data['keywords'])) {
           // Remove keywords from data to insert in pages_articles
           $this->_keywords = $data['keywords'];
           unset($data['keywords']);
           $this->getModel()->setData($data);
       }
    }
    
    /**
     * Synchronize pages_articles table with pages_articles_fulltext
     * on update and update keywords.
     * 
     * @see Tulipa_Model_Crud_Extra_Abstract::onAfterUpdate()
     */
    public function onAfterUpdate()
    {
        $data = $this->getModel()->getData();
        $dbTable = $this->getDbTable();
        
        $dbTable->update(array(
            'title' => $data['title'],
            'intro' => $data['intro'],
            'url' => $data['url'],
            'picture' => empty($data['picture']) ? null : $data['picture'],
            'content' => strip_tags($data['content']),
            'pageId' => $data['pageId']
        ), array('articleId = ?' => $this->getModel()->getId()));
        
        // Update keywords
        $this->_updateKeywords($this->getModel()->getId());
    }
    
    /**
     * Synchronize pages_articles table with pages_articles_fulltext
     * on delete.
     * 
     * @see Tulipa_Model_Crud_Extra_Abstract::onAfterDelete()
     */
    public function onAfterDelete()
    {
        $dbTable = $this->getDbTable();        
        $dbTable->delete(array('articleId = ?' => $this->getModel()->getId()));
    }
}