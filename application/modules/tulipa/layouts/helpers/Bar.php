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
 * @category   Tulipa
 * @package    Tulipa_Layout
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Bar.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Display bar.
 *  
 * @category   Tulipa
 * @package    Tulipa_Layout
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Tulipa_Layout_Helper_Bar extends Zend_View_Helper_Abstract
{   
    /**
     * @var Zend_View_Interface
     */
    protected $_view;
    
    /**
     * Get calling Zend_View object.
     * 
     * @param Zend_View_Interface
     * @return void
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    
    /**
     * Create notification bar.
     * 
     * @param string $text
     * @param string $content
     * @param string $icon
     * @param string $domId
     * @param boolean $closeButton
     * @return string
     */
    public function bar($title, $content, $icon = 'new_page', $domId = null, $closeButton = true)
    {
        return $this->_view
                    ->partial('default/document/main/content/bar.phtml',
                                array(
                                    'title'         => $title,
                                    'content'       => $content,
                                    'icon'          => $icon,
                                    'domId'         => $domId,
                                    'closeButton'   => $closeButton
                                ));
    }
}