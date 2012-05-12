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
 * @version    $Id: RenameSaveExtension.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Rename file, but save the extension.
 *  
 * @category   Application
 * @package    Application_Filter
 * @subpackage Rename
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Application_Filter_RenameSaveExtension implements Zend_Filter_Interface
{
    /**
     * @var string
     */
    protected $_name = null;
    
    /**
     * @var boolean
     */
    protected $_generateUniqueId = false;
    
    /**
     * @var boolean
     */
    protected $_prepend = false;
    
    /**
     * Constructor.
     * 
     * Set options.
     * 
     * @param array|string $options If is string - $options is the name
     * @return void
     */
    public function __construct($options)
    {
        if (is_string($options)) {
            $this->setName($options);
            return;
        } else 
        if (is_array($options)) {
            if (!empty($options['name'])) {
                $this->setName($options['name']);
            }
            if (!empty($options['prepend'])) {
                $this->setPrepend($options['prepend']);
            }
            if (!empty($options['generateUniqueId'])) {
                $this->setGenerateUniqueId($options['generateUniqueId']);
            }
        }
    }
    
    /**
     * Set Application_Filter_RenameSaveExtension::$_name
     * 
     * @param string $name
     * @return Application_Filter_RenameSaveExtension
     */
    public function setName($name = null)
    {
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Get Application_Filter_RenameSaveExtension::$_name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set Application_Filter_RenameSaveExtension::$_generateUniqueId
     * 
     * @param boolean $generateUniqueId
     * @return Application_Filter_RenameSaveExtension
     */
    public function setGenerateUniqueId($generateUniqueId = false)
    {
        $this->_generateUniqueId = (boolean) $generateUniqueId;
        return $this;
    }

    /**
     * Get Application_Filter_RenameSaveExtension::$_generateUniqueId
     * 
     * @return boolean
     */
    public function getGenerateUniqueId()
    {
        return $this->_generateUniqueId;
    }

    /**
     * Set Application_Filter_RenameSaveExtension::$_prepend
     *
     * @param boolean $prepend
     * @return Application_Filter_RenameSaveExtension
     */
    public function setPrepend($prepend = true)
    {
        $this->_prepend = (null === $prepend) ? true : (boolean) $prepend;
        return $this;
    }

    /**
     * Get Application_Filter_RenameSaveExtension::$_prepend
     *
     * @return boolean
     */
    public function getPrepend()
    {
        return $this->_prepend;
    }
    
    /**
     * Rename file, but save the extension
     * 
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $fileInfo = pathinfo($value);
        $extension = $fileInfo['extension'];
        $dirname = $fileInfo['dirname'];
        $filename = $fileInfo['filename'];
        
        $newName = $dirname . DIRECTORY_SEPARATOR 
                   . ($this->getGenerateUniqueId() ? uniqid($this->getName(), true) : $this->getName()) 
                   . '.' . strtolower($extension);
        
        if ($this->_prepend && $this->_generateUniqueId) {
            $newName = $dirname . DIRECTORY_SEPARATOR 
                                . uniqid($this->getName()) . '-' 
                                . $filename . '.' . strtolower($extension);
        }
        
        if (file_exists($value)) {
            rename($value, $newName);
        }
        
        return realpath($newName);  
    }

}