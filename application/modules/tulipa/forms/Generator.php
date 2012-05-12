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
 * @subpackage Generator
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Generator.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * `Setter` and `getter` methods generator form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Generator
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Application_Form_Abstract
 */
class Tulipa_Form_Generator extends Tulipa_Form_Abstract
{
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function init()
    {
        $this->setAction($this->url(array(), null));
        
        $elements[] = $this->createElement('hash', 'csrf')
                           ->setIgnore(true)
                           ->setSalt(__FILE__)
                           ->removeDecorator('Label');
        
        $elements[] = $this->createElement('text', 'className')
                           ->setRequired(true)
                           ->addFilter('StringTrim')
                           ->setLabel($this->translate('Class name'))
                           ->setValue('Example');
                           
        $elements[] = $this->createElement('textarea', 'attributes')
                           ->setRequired(true)
                           ->addFilter('StringTrim')
                           ->setAttrib('rows', 3)
                           ->setLabel($this->translate('Attributes'));
        
        $elements[] = $this->createElement('select', 'access')
                           ->setRequired(true)
                           ->addMultiOptions(array(
                                'protected' => 'protected',
                                'private' => 'private'
                           ))
                           ->setLabel($this->translate('Access'));
        
        $elements[] = $this->_createDescription('notice', $this->translate('Separate attributes with a comma. If you want to specify attribute`s type, simply save it in brackets next to the name attribute. Example: id(int), name(string), items(array).'));
        
        $this->addElements($elements);
                
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'generator', 
                                array("legend" => $this->translate('Generator for setter/getter class methods'), 
                                'class' => 'ui-corner-all'));
        
        $this->_createSubmit($this->translate('Generate'));
        
    }

}