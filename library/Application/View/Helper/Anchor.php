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
 * @version    $Id: Anchor.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Create link.
 *  
 * @category   Application
 * @package    Application_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Application_View_Helper_Anchor extends Zend_View_Helper_Abstract
{
    /**
     * Create link.
     * 
     * @param string $name
     * @param string $cssClass
     * @param string $url
     * @param string $id
     * @param string $elementName
     * @param string $onClick
     * @return string
     */
    public function anchor($name = null, $cssClass = null, $url = 'JavaScript:void(0)', $id = null, $elementName = 'a', $onClick = null)
    {
        return sprintf('<%5$s href="%1$s" class="%2$s" id="%3$s" onclick="%6$s">%4$s</%5$s>', $url, $cssClass, $id, $name, $elementName, $onClick);
    }
}