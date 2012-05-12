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
 * Articles controller.
 * 
 * Manage articles.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Default
 * @package    Default_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class ArticlesController extends Default_Controller_Action
{

    /**
     * Show page articles.
     * 
     * @return void
     */
    public function indexAction()
    {        
        // Zend_Paginator page
        $page = $this->_getParam('page', 1);
        
        $pagesModel = new Default_Model_Pages;
        
        $pageDetails = $pagesModel->getPageDetails(
            $this->_getParam('url'), $this->_getParam('id'), true, true
        );
        
        if (empty($pageDetails)) {
            $this->status('Страницата, която търсите не съществува', 'error', true);
            return;
        }        
        
        $this->view->page = $pageDetails;
        // Set meta data
        $this->_helper->metaData($pageDetails);
        
        $articlesModel = new Default_Model_PagesArticles;
        $topArticles = $articlesModel->getTopArticles($pageDetails['children'], 4, true, true);
        
        $excludeIDs = Default_Model_PagesArticles::getOnlyIDs($topArticles);
        $limit = 10;
        if ($page < 2 && !empty($topArticles) && $topArticles->count() >= 4) {
            $this->view->topArticles = $topArticles;
        }
        
        $articlesSelect = $articlesModel->getArticles(
            $pageDetails['children'], false, $excludeIDs, null, true, true
        );
        
        if (empty($articlesSelect)) {
            return;
        }
        
        $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($articlesSelect);
        Application_Model_Paginator::create(
            $paginatorAdapter, $page, 'articles', null, true, $limit
        );
    }
    
    /**
     * Read single article.
     * @return void
     */
    public function readAction()
    {
        $url = $this->_getParam('url');
        $date = $this->_getParam('date');
        $id = $this->_getParam('id');
        
        $articlesModel = new Default_Model_PagesArticles;
        $article = $articlesModel->getArticleDetails($url, $date, $id);
    
        if (empty($article)) {
            $this->status('Статията, която търсите не съществува', 'error', true);
            return;
        }

        // Increase views count for this article.
        Default_Model_PagesArticles::updateArticleViewsCount($article->id);
        
        // Set meta data
        $this->_helper->metaData($article);
        $this->view->article = $article;
        
        $this->view->pageIDs = Default_Model_Pages::getPageChildrenIdsStatic($article->pageId, true);
        
        /**
         * Fix for the navigation breadcrumbs - 
         * make page available in the navigation container
         */
        Zend_Controller_Front::getInstance()->getRequest()
                                            ->clearParams()
                                            ->setParams(array(
                                                'module' => 'default',
                                                'controller' => 'articles',
                                                'action' => 'index',
                                                'id' => $article->pageId,
                                                'url' => $article->pageUrl
                                            ));
    }
    
    /**
     * Search articles.
     * 
     * @return void
     */
    public function searchAction()
    {        
        $searchModel = new Default_Model_PagesArticles_Search;
        $articles = $searchModel->search($this->_getParam('keyword'));
        
        $this->view->keyword = $this->_getParam('keyword');
        
        $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($articles);
        Application_Model_Paginator::create($paginatorAdapter, $this->_getParam('page'), 'articles', array('keyword' => $this->_getParam('keyword')), true, 20);
    }
    
    /**
     * Get articles by tag.
     * 
     * @return void
     */
    public function byTagAction()
    {        
        $this->_helper->viewRenderer->setRender('search');
        
        $articles = Default_Model_PagesArticles::getByTag($this->_getParam('tag'));
        
        $this->view->keyword = $this->_getParam('tag');
        
        $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($articles);
        Application_Model_Paginator::create($paginatorAdapter, $this->_getParam('page'), 'articles', array('tag' => $this->_getParam('keyword')), true, 20);
    }
    
    /**
     * Redirect links from the old site.
     * @return void
     */
    public function redirectAction()
    {
        $id = $this->_getParam('id');
        if (empty($id)) {
            $this->render('read');
            return;
        }
        
        $this->_helper->redirector->gotoRouteAndExit(array(
            'id' => $id
        ), 'article-id', true);
    }
}