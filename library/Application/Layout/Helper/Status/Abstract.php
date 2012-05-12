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
 * @package    Application_Layout
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Abstract.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Display status messages.
 *  
 * @category   Application
 * @package    Application_Layout
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
abstract class Application_Layout_Helper_Status_Abstract extends Zend_View_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_partialPath = null;
    
    /**
     * Display status messages.
     * 
     * @param array|null $statusMessages
     * @return string
     */
    public function status($statusMessages = null)
    {
        $layoutPath = $this->view->layout()->getLayoutPath();
        
        /**
         * Add layout path as a view scripts path.
         */
        $this->view->addScriptPath($layoutPath);
                
        return $this->view
                    ->partial($this->_partialPath . '/' . 'status.phtml', 'default', 
                                array(
                                    'statusMessages' => $statusMessages
                                ));
    }
    
    /**
     * Check if there are errors in the messages.
     * 
     * @return boolean
     */
    public function hasErrors()
    {
        $statusMessages = $this->view->statusMessages;
        
        if (empty($statusMessages)) {
            return false;
        }
        
        if (!count($statusMessages)) {
            return false;
        }
        
        foreach ($statusMessages as $message) 
        {
            if ($message['isError']) {
                return true;
            }
        }
        
        return false;
    }
}