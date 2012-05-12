<?php
/**
 * Default © Core 
 * Copyright © 2010 Sasquatch <Joan-Alexander Grigorov>
 *                      http://bgscripts.com
 * 
 * LICENSE
 * 
 * A copy of this license is bundled with this package in the file LICENSE.txt.
 * 
 * Copyright © Default
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
 * @category   Default
 * @package    Default_Controllers
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Status.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Controller helper for setting meta data.
 * 
 * @category   Default
 * @package    Default_Controllers
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Action_Helper_MetaData extends 
    Zend_Controller_Action_Helper_Abstract
{
    
    /**
     * Strategy pattern: call helper as helper broker method.
     * 
     * Add meta data to the view.
     * 
     * @param Zend_Db_Table_Row|array $metaDataHolder
     * @return void
     */
    public function direct($metaDataHolder)
    {
        if (empty($metaDataHolder)) {
            return;
        }
        
        if (!is_array($metaDataHolder) && $metaDataHolder instanceof Zend_Db_Table_Row) {
            $metaDataHolder = $metaDataHolder->toArray();
        }
        
        if (is_array($metaDataHolder)) {
            if (isset($metaDataHolder['metaTitle'])) {
                $this->getActionController()->view->seoTitle = $metaDataHolder['metaTitle'];
            }
            if (isset($metaDataHolder['metaKeywords'])) {
                $this->getActionController()->view->seoKeywords = $metaDataHolder['metaKeywords'];
            }
            if (isset($metaDataHolder['metaDescription'])) {
                $this->getActionController()->view->seoDescription = $metaDataHolder['metaDescription'];
            }
        }
    }
}