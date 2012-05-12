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
 * @package    Application_Filter
 * @subpackage Md5
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Md5.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Md5 Filter.
 *  
 * @category   Application
 * @package    Application_Filter
 * @subpackage Md5
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Application_Filter_Md5 implements Zend_Filter_Interface
{
    /**
     * Hash $value with md5()
     * 
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        /**
         * Filter value with md5()
         */
        return md5($value);    
    }

}