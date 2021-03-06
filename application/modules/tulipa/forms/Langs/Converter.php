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
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Converter.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Language form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Langs_Converter extends Tulipa_Form_Abstract
{
    /**
     * Configure register form
     *
     * @return void
     */ 
    public function init()
    { 	
        $this->setAction($this->url(array('request' => 'ajax'), null));
        
        /** Create email element. **/
        $mo = $this->createElement('file', 'mo');
        $mo->setDestination($this->_getSettings()->tempPath . '/langs')
           ->setLabel($this->translate(".mo file"))
           ->addValidator('Count', false, 1)
           ->addValidator('Extension', false, 'mo')
           ->setRequired();
               
        $this->addElement($mo);
        
        $this->addDisplayGroup(array('mo'), 'moUpload', array("legend" => $this->translate('.mo converter')));
        		
        $this->_createSubmit($this->translate('Convert'));
        
    }


}