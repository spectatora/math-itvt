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
 * @subpackage Image
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Resize.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Image resize filter.
 *  
 * @category   Application
 * @package    Application_Filter
 * @subpackage Image
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Application_Filter_Image_Resize implements Zend_Filter_Interface
{
    /**
     * @var int
     */
    protected $_width = null;

    /**
     * @var int
     */
    protected $_height = null;
    
    /**
     * @var string
     */
    protected $_newFileName = null;
    
    /**
     * @var string
     */
    protected $_adapter = 'ImageMagick';
    
    /**
     * Constructor.
     * 
     * Set options.
     * 
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null)
    {
        if (isset($options['width'])) {
            $this->setWidth($options['width']);
        }
        
        if (isset($options['height'])) {
            $this->setHeight($options['height']);
        }
        
        if (isset($options['adapter'])) {
            $this->setAdapter($options['adapter']);
        }
        
        if (isset($options['newFileName'])) {
            $this->setNewFileName($options['newFileName']);
        }
    }
    
    /**
     * Set Application_Filter_Image_Resize::$_width
     * 
     * @param int $width
     * @return Application_Filter_Image_Resize
     */
    public function setWidth($width = null)
    {
        $this->_width = (int) $width;
        return $this;
    }

    /**
     * Get Application_Filter_Image_Resize::$_width
     * 
     * @return int
     */
    public function getWidth()
    {
        return $this->_width;
    }

    /**
     * Set Application_Filter_Image_Resize::$_height
     * 
     * @param int $height
     * @return Application_Filter_Image_Resize
     */
    public function setHeight($height = null)
    {
        $this->_height = (int) $height;
        return $this;
    }

    /**
     * Get Application_Filter_Image_Resize::$_height
     * 
     * @return int
     */
    public function getHeight()
    {
        return $this->_height;
    }

    /**
     * Set Application_Filter_Image_Resize::$_newFileName
     * 
     * @param string $newFileName
     * @return Application_Filter_Image_Resize
     */
    public function setNewFileName($newFileName = null)
    {
        $this->_newFileName = (string) $newFileName;
        return $this;
    }

    /**
     * Get Application_Filter_Image_Resize::$_newFileName
     * 
     * @return string
     */
    public function getNewFileName()
    {
        return $this->_newFileName;
    }

    /**
     * Set Application_Filter_Image_Resize::$_adapter
     *
     * @param string $adapter
     * @return Application_Filter_Image_Resize
     */
    public function setAdapter($adapter)
    {
        $this->_adapter = (null === $adapter) ? null : (string) $adapter;
        return $this;
    }

    /**
     * Get Application_Filter_Image_Resize::$_adapter
     *
     * @return string
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }
    
    /**
     * Resize image
     * 
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        if (!empty($this->_newFileName)) {
            $fileName = $this->_newFileName;
        } else {
            $fileName = $value;
        }
        
        $imageProccessor = Application_Image::factory($this->getAdapter());
                
        $imageProccessor->setFile($value)->resizeLimit($fileName, $this->getWidth(), $this->getHeight());
        return $value;
    }

}