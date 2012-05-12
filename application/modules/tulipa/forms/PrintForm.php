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
 * @subpackage Login
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Login.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Login form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Login
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Application_Form_Abstract
 */
class Tulipa_Form_PrintForm extends Tulipa_Form_Abstract
{
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function init()
    {
        $this->setAction($this->url(array(), 'tulipa'));

	$elements[] = $this->createElement('select', 'purpose')
			   ->setMultiOptions(array('1'=>'Разпределение на участници', '2'=>'Стая'))
		           ->setRequired(true)
			   ->addValidator('NotEmpty', true)
			   ->setLabel('Заявка');
        
        $elements[] = $this->createElement('text', 'room')
                           ->addFilter('Alnum')
                           ->setRequired(false)
                           ->setLabel('Стая');

	
        
        $this->addElements($elements);
                
/*
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'login', 
                                array("legend" => $this->translate('User login'), 
                                'class' => 'ui-corner-all'));
 */       
        $this->_createSubmit($this->translate('Enter'));
        
    }

}
