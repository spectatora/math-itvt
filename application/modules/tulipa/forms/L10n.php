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
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: L10n.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Localization filter form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_L10n extends Tulipa_Form_Abstract
{   
    /**
     * Create form elements.
     *
     * @return void
     */ 
    public function init()
    {
        $this->setAction($this->url(array(
            'module' => 'tulipa', 'controller' => 'cities', 'action' => 'index'
        ), 'default', true))
             ->setMethod('get')
             ->setAttrib('class', 'filter');
        
        $countries = $this->_getCountriesMultiSelect();
        
        if (!empty($countries)) {
            $elements[] = $this->createElement('select', 'countryId')
                               ->addFilter('int')
                               ->addMultiOptions($this->_getCountriesMultiSelect())
                               ->setRequired(true)
                               ->removeValidator('InArray')
                               ->setLabel($this->translate('Country'));
        } else {
            $this->addDecorator('Errors');
            $this->addError($this->translate('No countries found'));
            return;
        }
        
        /** Add all elements to the form. **/
        $this->addElements($elements);
                                
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'l10n', 
                                array("legend" => $this->translate('Cities'), 
                                'class' => 'ui-corner-all'));
                                
        $this->_createSubmit($this->translate('Filter'));
        
        
    }    
    
    /**
     * Generate countries select options.
     * 
     * @return array
     */
    protected function _getCountriesMultiSelect()
    {
    	
        $countries = Application_Model_L10n::browse('countries');
        if (!empty($countries)) {
            $multiOptions = array(null => $this->translate('All'));
            foreach ($countries as $country)
            {
                $multiOptions[$country['id']] = ucfirst($country['name']);
            }
            return $multiOptions;
        }
    }
    
}