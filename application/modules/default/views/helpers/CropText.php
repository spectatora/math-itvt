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
 * Substring text and add dots.
 *  
 * @category   Default
 * @package    Default_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Default_View_Helper_CropText extends Zend_View_Helper_Abstract
{
    /**
     * Substring text and add dots.
     * 
     * @param 	string 	$text
     * @param 	integer $limit
     * @return 	string
     */
    public function cropText($text, $limit)
    {
        if (strlen($text) <= $limit) {
            return $text;
        } else {
            return substr($text, 0, $limit) . '...';
        }
    }
}