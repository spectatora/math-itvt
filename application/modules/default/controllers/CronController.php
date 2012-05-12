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
 * @package    Default_Controllers
 * @subpackage Index
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: IndexController.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Cron jobs controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Default
 * @package    Default_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class CronController extends Default_Controller_Action
{
    /**
     * Check is in CLI mode.
     * 
     * @return void
     */
    public function init()
    {
        if (!defined('CLI_MODE')) {
            throw new Zend_Exception('This controller is avaliable only in CLI mode');
            exit;
        }
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
    }
    
    /**
     * Synchronize pages_articles DB Table with pages_articles_fulltext 
     * DB Table.
     * 
     * @return void
     */
    public function syncArticlesAction()
    {
        $articles = Tulipa_Crud::getModel('pages-articles')->browse(true);
        $replDbTable = new Application_Db_Table('pages_articles_fulltext');
        
        echo 'Starting synchronization.' . PHP_EOL . PHP_EOL;
        
        // sync from pages_articles
        foreach ($articles as $article)
        {
            $articleId = $article['id'];
            $select = $replDbTable->select()->where('articleId = ?', $articleId, 'INTEGER');
            $row = $replDbTable->fetchRow($select);
            if (null === $row) {
                $replDbTable->insert(array(
                    'title' => $article['title'],
                    'intro' => $article['intro'],
                    'date' => $article['date'],
                    'url' => $article['url'],
            		'picture' => $article['picture'],
                    'content' => strip_tags($article['content']),
                    'articleId' => $articleId,
                    'pageId' => $article['pageId']
                ));
                echo ' + Added new article with id: ' . $articleId . PHP_EOL;
            } else {
                if ($article['title'] != $row['title'] ||
                    $article['intro'] != $row['intro'] ||
                    $article['date'] != $row['date'] ||
                    $article['url'] != $row['url'] ||
                    $article['picture'] != $row['picture'] ||
                    strip_tags($article['content']) != $row['content'] ||
                    $article['pageId'] != $row['pageId']) {
                        $replDbTable->update(array(
                            'title' => $article['title'],
                            'intro' => $article['intro'],
                    		'date' => $article['date'],
                    		'url' => $article['url'],
                    		'picture' => $article['picture'],
                            'content' => strip_tags($article['content']),
                            'pageId' => $article['pageId']
                        ), array('articleId = ?' => $articleId));
                        echo ' - Updated article with id: ' . $articleId . PHP_EOL;
                    }
            }
        }
        
        // sync from pages_articles_fulltext
        $rows = $replDbTable->fetchAll();
        $articlesDbTable = new Application_Db_Table('pages_articles');
        
        foreach ($rows as $row)
        {
            $article = $articlesDbTable->fetchRow(array('id = ?' => $row->articleId));
            if (empty($article)) {
                $replDbTable->delete(array('id = ?' => $row->id));
                echo ' - Deleted article with id: ' . $row->articleId . PHP_EOL;
            }
        }
        
        echo 'Synchronization finished.' . PHP_EOL;
    }
    
    public function fixIntrosAction()
    {
        $replDbTable = new Application_Db_Table('pages_articles');
        $rows = $replDbTable->fetchAll();
        foreach ($rows as $row)
        {
            $replDbTable->update(array(
                'intro' => trim(strip_tags(htmlspecialchars_decode($row->intro))),
                'date' => $row->date
            ), array('id = ?' => $row->id));
            echo ' - Updated article with id: ' . $row->id . PHP_EOL;
        }
    }
}