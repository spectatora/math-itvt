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
 * @category   Default
 * @package    Default_Forms
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Abstract.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Abstract class for all forms.
 * 
 * @category   Default
 * @package    Default_Forms
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Default_Form_Abstract extends Application_Form_Abstract
{    
    
    const CSRF_TIMEOUT = 1800;
    
    /**
     * Add a display group
     *
     * Groups named elements for display purposes.
     *
     * If a referenced element does not yet exist in the form, it is omitted.
     *
     * @param  array $elements
     * @param  string $name
     * @param  array|Zend_Config $options
     * @return Zend_Form
     */
    public function addDisplayGroup(array $elements, $name, $options = null)
    {
        Zend_Form::addDisplayGroup($elements, $name, $options);
        
        $this->getDisplayGroup($name)
             ->removeDecorator('DtDdWrapper');
        
        return $this;
    }
    
    /**
     * Create submit element.
     * 
     * @param string $label
     * @return Zend_Form
     */
    protected function _createSubmit($label = null)
    {
        $element = $this->createElement('submit', 'formSubmit')
                        ->setIgnore(true)
                        ->setLabel($label)
                        ->setAttrib('class', 'iconButton')
                        ->removeDecorator('DtDdWrapper');
        return $this->addElement($element);
    }
    
    /**
     * Create an element
     *
     * @param  string $type
     * @param  string $name
     * @param  array|Zend_Config $options
     * @return Zend_Form_Element
     */
    public function createElement($type, $name, $options = null)
    {
        $element = Zend_Form::createElement($type, $name, $options);        
        return $element;
    }
    
    /**
     * Create captcha element.
     * 
     * Uses reCaptcha service.
     * 
     * @return Zend_Form
     */
    protected function _createCaptcha()
    {
        
        /** ReCaptcha service **/
        $reCaptchaSettings = Zend_Registry::get('COMMON_SETTINGS')->reCaptcha;
        
        $reCaptchaService = new Zend_Service_ReCaptcha(
            $reCaptchaSettings->publicKey, 
            $reCaptchaSettings->privateKey, 
            array('ssl' => false), 
            array(
                'lang' => 'bg',
                'theme' => 'white',
                'custom_translations' => array(
                    'instructions_visual' => $this->translate('Type the two words'),
                    'play_again' => $this->translate('Play again'),
                    'cant_hear_this' => $this->translate('Download as MP3'),
                    'visual_challenge' => $this->translate('Use visual challenge'),
                    'audio_challenge' => $this->translate('Use aduio challenge'),
                    'refresh_btn' => $this->translate('Refresh'),
                    'help_btn' => $this->translate('Help'),
                    'incorrect_try_again' => $this->translate('Incorrect! Try again')
                )
            )
        ); 
        
        $element = $this->createElement('captcha', 'captcha', array(
                                            'captcha'        => 'ReCaptcha',
                                            'captchaOptions' => array('captcha' => 'ReCaptcha', 
                                                                    'service' => $reCaptchaService))
                                       );
        $element->getCaptcha()
                ->setMessage($this->translate('Missing value'), Zend_Captcha_ReCaptcha::MISSING_VALUE)
                ->setMessage($this->translate('Incorrect'), Zend_Captcha_ReCaptcha::BAD_CAPTCHA)
                ->setMessage($this->translate('Error'), Zend_Captcha_ReCaptcha::ERR_CAPTCHA);
                        
        return $element;
    }
}
