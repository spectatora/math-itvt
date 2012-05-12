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
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Search.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Users filter form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Users_Search extends Tulipa_Form_Abstract
{   
    /**
     * Create form elements.
     *
     * @return void
     */ 
    public function init()
    {
        $this->setAction($this->url(array(
            'module' => 'tulipa', 'controller' => 'users', 'action' => 'index'
        ), 'default', true))
             ->setMethod('get')
             ->setAttrib('class', 'filter');
        
        $elements[] = $this->createElement('text', 'keyword')
                           ->addFilter('alnum')
                           ->removeDecorator('label');
        
        /** Add all elements to the form. **/
        $this->addElements($elements);
                                
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'users', 
                                array("legend" => $this->translate('Search'), 
                                'class' => 'ui-corner-all'));
                                
        $this->_createSubmit($this->translate('Filter'));
        
    }    
}