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
 * @package    Application_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Ngettext.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Plural translations.
 *  
 * @category   Application
 * @package    Application_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Application_View_Helper_Ngettext extends Zend_View_Helper_Abstract
{
    /**
     * Plural notations translation.
     * 
     * @return string
     */
    public function ngettext()
    {
        $arguments = func_get_args();
        $argumentsReversed = array_reverse($arguments);
        
        $count = null;
        
        if (is_numeric($argumentsReversed[0])) {
            $count = $argumentsReversed[0];
        } 
        
        if (is_numeric($argumentsReversed[1])) {
            $count = $argumentsReversed[1];
        }
        
        return $this->view->translate($arguments, $count);
    }
}