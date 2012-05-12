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
 * @version    $Id: CssImport.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
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
class Application_View_Helper_CssImport extends Zend_View_Helper_Abstract
{
    const XML_FILE = '/configs/css.xml';
    
    /**
     * Import CSS includes from the module's css.xml file.
     * 
     * @param string $xmlFile
     * @return string
     */
    public function cssImport($xmlFile = null)
    {
        if (null === $xmlFile) {
            $frontController = Zend_Controller_Front::getInstance();
            $xmlFile = realpath($frontController->getModuleDirectory() . self::XML_FILE);
        }
        
        if (!file_exists($xmlFile)) {
            return $this->view->headLink();
        }
        
        /**
         * Using {@see Zend_Config_Xml} load the xml file 
         * and import the includes.
         * 
         * CSSImport uses application enviorment sections.
         */
        $xmlConfig = new Zend_Config_Xml($xmlFile, APPLICATION_ENV);
        
        $importArray = $xmlConfig->toArray();        
                
        if (isset($importArray['items']['item'])) {
            $importArray['items'][0]['item'] = $importArray['items']['item'];
            $importArray['items'][0]['path'] = $importArray['items']['path'];
            unset($importArray['items']['item'], 
                  $importArray['items']['path']);
        }

        
        if (!empty($importArray)) {
            if (!empty($importArray['items'])) {
                foreach ($importArray['items'] as $items) {
                    
                    // Base url
                    $path = empty($items['path']) ? '' : $items['path'];
                    
                    if (!empty($items['item'])) {
                        if (is_array($items['item'])) {
                            foreach ($items['item'] as $item)
                            {
                                $this->view
                                     ->headLink()
                                     ->appendStylesheet($this->view->baseUrl($path . $item));
                            }
                        } else {
                            $this->view
                                 ->headLink()
                                 ->appendStylesheet($this->view->baseUrl($path . $items['item']));
                        }
                    }
                }
            }
        }
        
        $this->view->headLink()->setSeparator("\n        ");
        return $this->view->headLink();
    }
}
