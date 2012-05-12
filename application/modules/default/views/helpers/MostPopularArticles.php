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
 * @package    Default_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: FormErrors.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/** 
 * Show most popular articles.
 *  
 * @category   Default
 * @package    Default_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Default_View_Helper_MostPopularArticles extends Zend_View_Helper_Abstract
{
    /**
     * Partial script to render.
     * @var string
     */
    protected $_partial = 'articles/partial/popular.phtml';
    
    /**
     * Show most popular articles (limited).
     * 
     * @param 	int		$limit
     * @param 	string	$title
     * @param 	array	$pageIDs
     * @return 	string
     */
    public function mostPopularArticles($limit, $title = 'Популярни', $pageIDs = null)
    {
        $articlesModel = new Default_Model_PagesArticles;
        return $this->view->partial($this->_partial, 'default', array(
            'articles' => $articlesModel->getMostPopularArticles($pageIDs, $limit),
            'title' => $title
        ));
    }
}