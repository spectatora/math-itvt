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
 * @version    $Id: JsImport.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
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
class Application_View_Helper_JsImport extends Zend_View_Helper_Abstract
{
    const XML_FILE = '/configs/js.xml';
    const CACHE_PATH = '/resources/common/js/cache/';
    
    /**
     * Import JavaScript includes from the modules js.xml file.
     * 
     * @param string $xmlFile
     * @return string
     */
    public function jsImport($xmlFile = null)
    {
        if (null === $xmlFile) {
            $frontController = Zend_Controller_Front::getInstance();
            $xmlFile = realpath($frontController->getModuleDirectory() . self::XML_FILE);
        }
        
        if (!file_exists($xmlFile)) {
            return $this->view->headScript();
        }
        
        /**
         * Using {@see Zend_Config_Xml} load the xml file 
         * and import the includes.
         * 
         * JSImport uses application enviorment sections.
         */
        $xmlConfig = new Zend_Config_Xml($xmlFile, APPLICATION_ENV);
        
        $importArray = $xmlConfig->toArray();
        
        if (isset($importArray['items']['item'])) {
            $importArray['items'][0]['item'] = $importArray['items']['item'];
            $importArray['items'][0]['path'] = $importArray['items']['path'];
            $importArray['items'][0]['pack'] = isset($importArray['items']['pack']) ? $importArray['items']['pack'] : false;
            unset($importArray['items']['item'], 
                  $importArray['items']['path'], 
                  $importArray['items']['pack']);
        }
        
        if (!empty($importArray)) {
            if (!empty($importArray['items'])) {
                foreach ($importArray['items'] as $items) {
                    // Flag for packing files
                    $packFiles = isset($items['pack']) ? 
                                    (bool) $items['pack'] : false;
                    // Base url
                    $path = empty($items['path']) ? '' : $items['path'];
                    
                    if (!empty($items['item'])) {
                        if (!$packFiles) {
                            if (is_string($items['item'])) {
                                $this->view
                                     ->headScript()
                                     ->appendFile($this->view->baseUrl($path . $items['item']), 'text/javascript');
                            } else {
                                foreach ($items['item'] as $item) 
                                {
                                    $this->view
                                         ->headScript()
                                         ->appendFile($this->view->baseUrl($path . $item), 'text/javascript');
                                }
                            }
                        } else {
                            // Create cache for files or get existing one
                            $this->_cache($items['item'], $path);
                        }
                    }
                }
            }
        }
        
        $this->view->headScript()->setSeparator("\n        ");
        return $this->view->headScript();
    }
    
    /**
     * Manage files packing and cache.
     * 
     * Creates a packed and compressed file from the
     * passed files.
     * 
     * @param array  $items Files to pack
     * @param string $path Base path of the files
     * @return void
     */
    protected function _cache($items, $path)
    {
        if (empty($items)) {
            return;
        }
        
        // Get module's name - used in the cache id.
        $moduleName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
        
        // Check if there is an existing cache
        $cacheId = $moduleName . '_' . md5(serialize($items));
        $cacheFileName = realpath(APPLICATION_PATH . '/../public_html/' . self::CACHE_PATH) 
                         . '/' . $cacheId . '.js';
        
        // If the cache exists - append the file
        if (!file_exists($cacheFileName)) {
        
            $workingPath = realpath(APPLICATION_PATH . '/../public_html/') . $path;
            $overallContents = null;
            
            foreach ($items as $item)
            {
                $fileName = $workingPath . $item;
                if (file_exists($fileName)) {
                    // Get the files contents and add it to the overall
                    $overallContents .= '/** ' . $item . ' **/' 
                                     . "\n\n" . file_get_contents($fileName) 
                                     . "\n\n";
                } else {
                    die($fileName . ' not found');
                }
            }
            
            if (null !== $overallContents) {
                file_put_contents($cacheFileName, $overallContents);
            }
        }
        
        $this->view
             ->headScript()
             ->appendFile($this->view->baseUrl(self::CACHE_PATH . $cacheId . '.js'), 
                            'text/javascript');
    }
}
