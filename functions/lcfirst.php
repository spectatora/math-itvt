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
 * @package    Application_Functions
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: get_called_class.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */
 
/**
 * Retro-support for lcfirst().
 * Make a string's first character lowercase.
 */
if(!function_exists('lcfirst')) {
    function lcfirst($string)
    {
        if (is_string($string) && null !== $string) {
            $string{0} = strtolower($string{0});
        } 
        return $string;
    }
} 
