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
 * @subpackage Pages
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Filter.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD module form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Crud_Filter extends Tulipa_Form_Crud
{    
    /**
     * @see Zend_Form::init()
     */
    public function init()
    {
        $this->setMethod('get')
             ->setAttrib('class', 'filter');
        
        $elements = $this->getElements();
        
        $urlArray = array('request' => 'ajax');
        
        foreach ($elements as $elementName => $element)
        {
            $urlArray[$elementName] = null;
            $label = $element->getLabel();
            if (empty($label)) {
                $element->removeDecorator('label');
            }
        }
                
        $this->setAction($this->url($urlArray, 'crud'));

        $this->_createSubmit($this->translate('Filter'));
    }
}