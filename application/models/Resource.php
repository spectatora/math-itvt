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
 * @package    Application_Models
 * @subpackage Resource
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Resource.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Class for Acl Assertion Resource.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Resource
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Resource implements 
    Zend_Acl_Resource_Interface
{
    
    /**
     * @var string
     */
    protected $_resourceId = null;

    /**
     * Set Application_Model_Resource::$_resourceId
     * 
     * @param string $resourceId
     * @return Application_Model_Resource
     */
    public function setResourceId($resourceId = null)
    {
        $this->_resourceId = (string) $resourceId;
        return $this;
    }

    /**
     * Get Application_Model_Resource::$_resourceId
     * 
     * @return string
     */
    public function getResourceId()
    {
        return $this->_resourceId;
    }
    
        
    /**
     * Constructor.
     * 
     * Sets model options.
     * 
     * @param  array|null|string $options   If $options is string, it's 
     *                                      assumed for option key
     * @return void
     */
    public function __construct($options = null)
    {
        if (func_num_args() > 1) {
            if (is_string($options)) {
                $key = $options;
                $method = 'set' . ucfirst($key);
                $value = func_get_arg(1);
                $this->$method($value);
                return;
            }
        }
        
        if (is_array($options)) {
            $this->setOptions($options);
        }                
    }
    
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Application_Model_Abstract
     */
    public function setOptions($options)
    {
        if (empty($options)) {
            return $this;
        }
        
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}