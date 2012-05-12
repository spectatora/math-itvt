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
 * Index controller.
 * 
 * Site home page.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Default
 * @package    Default_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class TestController extends Default_Controller_Action
{
    /**
     * Disable page cache.
     * 
     * @see Application_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        Zend_Registry::get('PAGE_CACHE')->cancel();
    }
    
    /**
     * Show last news.
     * 
     * @return void
     */
    public function indexAction()
    {
        $articlesModel = new Default_Model_PagesArticles;
        $topArticles = $articlesModel->getTopArticles();
        
        $this->view->topNews = $topArticles;
                
        // We want to exclude articles from the rest of the last news
        $excludeIDs = null;
        if (!empty($topArticles) && count($topArticles) >= 4) {
            $excludeIDs = Default_Model_PagesArticles::getOnlyIDs($topArticles);
        }
                
        $this->view->lastNews = $articlesModel->getArticles(null, true, $excludeIDs, 10);
    }


	 public function registerAction()
    {
        $request = $this->getRequest();
        
        $form = new Default_Form_Register;
        
        $this->view->form = $form;
        
    }
}
