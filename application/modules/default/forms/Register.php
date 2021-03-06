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
 * @version    $Id: Login.php 135 2011-07-31 22:17:49Z sasquatch@bgscripts.com $
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
class Default_Form_Register extends Default_Form_Abstract
{
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function init()
    {
        $this->setAction($this->url(array(), 'default'));
	$this->setMethod('post');
        
        /*
        $elements[] = $this->createElement('hash', 'csrf')
                           ->setIgnore(true)
                           ->setSalt(__FILE__)
                           ->removeDecorator('Label');*/
        
        $elements[] = $this->createElement('text', 'names')
//                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Име, презиме, фамилия'));


	$elements[] = $this->createElement('text', 'city')
//                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Град'));

	$elements[] = $this->createElement('text', 'school')
//                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Училище'));

/*
	$elements[] = $this->createElement('text', 'grade')
                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Grade'));

*/	
	$elements[] = $this->createElement('select', 'grade')
			   ->setMultiOptions(array('11'=>'11', '12'=>'12'))
		           ->setRequired(true)
			   ->addValidator('NotEmpty', true)
			   ->setLabel($this->translate('Клас'));

/*
	$elements[] = $this->createElement('text', 'level')
                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Level'));
*/
	$elements[] = $this->createElement('select', 'level')
			   ->setMultiOptions(array('1'=>'1', '2'=>'2'))
		           ->setRequired(true)
			   ->addValidator('NotEmpty', true)
			   ->setLabel($this->translate('Равнище'));

	$elements[] = $this->createElement('text', 'teacher')
//                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Преподавател (име, презиме, фамилия)'));

	$elements[] = $this->createElement('text', 'address')
//                           ->addFilter('Alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Адрес'));


	//email validator
	$emailValidator = new Zend_Validate_EmailAddress();
    	$emailValidator->setOptions(array('domain' => false));

	$elements[] = $this->createElement('text', 'email')
//                           ->addFilter('Alnum')
			   ->addValidator($emailValidator)
//			   ->addValidator('regex', false, array('/^[a-z]/i'))
//			   ->addValidator(new Zend_Validate_EmailAddress())
                           ->setRequired(true)
                           ->setLabel($this->translate('Email'));


	$digitsValidator = new Zend_Validate_Digits();

	$elements[] = $this->createElement('text', 'phone')
//                           ->addFilter('Alnum')
			   ->addValidator($digitsValidator)
                           ->setRequired(true)
                           ->setLabel($this->translate('Телефон'));
	
//	$elements[] = $this->_createCaptcha();

	
	$captcha = $this->createElement('captcha', 'captcha',
	array('required' => true,
	'captcha' => array('captcha' => 'Image',
	'font' => APPLICATION_PATH. '/../public_html/resources/fonts/FreeSerifBold.ttf',
	'fontSize' => '24',
	'wordLen' => 5,
	'height' => '70',
	'width' => '100',
	'imgDir' => APPLICATION_PATH.'/../public_html/captcha',
	'imgUrl' => Zend_Controller_Front::getInstance()->getBaseUrl().
	'/captcha',
	'dotNoiseLevel' => 30,
	'lineNoiseLevel' => 5)));

	$captcha->setLabel('Въведете текста от картинката:');
	
	$elements[] = $captcha;



        //address-book-new
        
        $this->addElements($elements);

	
// /*   
		$this->_createSubmit($this->translate('Регистрирай'));    
	       
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'register', 
                                array("legend" => $this->translate('Регистрация на участник'), 
                                'class' => 'ui-corner-all'));
        
// */		        


        
    }

}
