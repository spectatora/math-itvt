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
 * @version    $Id: Thumb.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
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
class Application_Filter_Image_Thumb extends Application_Filter_Image_Resize
{
    
    /**
     * @var string
     */
    protected $_thumbFolder = 'thumbs';
    
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
        parent::__construct($options);
        if (isset($options['thumbFolder'])) {
            $this->setThumbFolder($options['thumbFolder']);
        }
    }

    /**
     * Set Application_Filter_Image_Thumb::$_thumbFolder
     *
     * @param string $thumbFolder
     * @return Application_Filter_Image_Thumb
     */
    public function setThumbFolder($thumbFolder)
    {
        $this->_thumbFolder = (null === $thumbFolder) ? null : (string) $thumbFolder;
        return $this;
    }

    /**
     * Get Application_Filter_Image_Thumb::$_thumbFolder
     *
     * @return string
     */
    public function getThumbFolder()
    {
        return $this->_thumbFolder;
    }
    
    /**
     * Resize image
     * 
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $fileName = $value;
        $fileName = dirname($fileName) . '/' 
                    . $this->_thumbFolder . '/' 
                    . basename($fileName);
        
        $imageProccessor = Application_Image::factory($this->getAdapter());
                
        $imageProccessor->setFile($value)->resizeLimit($fileName, $this->getWidth(), $this->getHeight());
        return $value;
    }

}