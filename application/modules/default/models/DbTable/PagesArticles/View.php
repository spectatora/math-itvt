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
 * @subpackage DBTable
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Settings.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * DBTable class for pages_articles_view.
 * 
 * @category   Default
 * @package    Default_Models
 * @subpackage DBTable
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Model_DbTable_PagesArticles_View extends Zend_Db_Table_Abstract
{
    
    /**
     * DB Table name.
     * @var string
     */
    protected $_name = 'pages_articles_view';
    
    /**
     * DB Table primary key column.
     * @var string
     */
    protected $_primary = 'id';
    
}

