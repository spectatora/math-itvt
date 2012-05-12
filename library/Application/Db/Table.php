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
 * @category   Application
 * @package    Application_DB
 * @subpackage Table
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Table.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Application
 * @package    Application_DB
 * @subpackage Table
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Db_Table extends Zend_Db_Table
{
    /**
     * @var string
     */
    protected $_primary = 'id';
    
    /**
     * Set Zend_Db_Table::$_primary
     * 
     * @param string $primary
     * @return Application_Db_Table
     */
    public function setPrimary($primary = null)
    {
        $this->_primary = (string) $primary;
        return $this;
    }

    /**
     * Get Zend_Db_Table::$_primary
     * 
     * @return string
     */
    public function getPrimary()
    {
        return $this->_primary;
    }
}