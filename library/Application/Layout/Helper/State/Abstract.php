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
abstract class Application_Layout_Helper_State_Abstract extends Zend_View_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_partialPath = null;
    
    /**
     * Get partial string.
     * 
     * @param string $content
     * @param string $type
     * @return string
     */
    protected function _state($content, $type)
    {
        $layoutPath = $this->view->layout()->getLayoutPath();
        
        /**
         * Add layout path as a view scripts path.
         */
        $this->view->addScriptPath($layoutPath);
                
        return $this->view->partial($this->_partialPath . '/' . strtolower($type) . '.phtml',
            array(
                'content' => $content
            )
        );
    }
    
    /**
     * Overloading: if the method doesn`t exists
     * call the _state() method.
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return mixed|void
     */
    public function __call($name, $value)
    {
        $method = $name;
        
        if (method_exists($this, $method)) {
            return call_user_func_array(
                array($this, $method), $value
            );
        } else {
            $method = strtolower($method);
            $method = str_replace('state', '', $method);
            $value[] = $method;
            
            return call_user_func_array(
                array($this, '_state'), $value
            );
        }
    }
}