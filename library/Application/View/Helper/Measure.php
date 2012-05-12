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
 * @version    $Id: Measure.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Generates line breaks.
 *  
 * @category   Application
 * @package    Application_View
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Zend_View_Helper_Abstract
 */
class Application_View_Helper_Measure extends Zend_View_Helper_Abstract
{   
    /**
     * Generates line breaks.
     * 
     * @param Zend_Measure_Abstract $measureObject
     * @param int $round
     * @param boolean $pluralForm User plural forms for translations
     * @return string
     */
    public function measure(Zend_Measure_Abstract $measureObject, $round = -1, $pluralForm = true)
    {        
        $value = $measureObject->getValue($round);
        $conversionList = $measureObject->getConversionList();
        $type = $measureObject->getType();
        $measure = $conversionList[$type][1];
        $translation = $pluralForm ? $this->view->translate(array($measure, $measure, $value)) : $this->view->translate($measure);
        return $value . ' ' . $translation;
    }
}

?>