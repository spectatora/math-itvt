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
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Abstract.php 111 2011-04-21 08:22:50Z sasquatch@bgscripts.com $
 */

/**
 * Abstract class for all forms.
 * 
 * @category   Application
 * @package    Application_Forms
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Form_Abstract extends Zend_Form
{
    const CSRF_TIMEOUT = 1500;
    
    /**
     * Form configuration.
     * @var Zend_Config_Ini
     */
    protected $_config = null;
    
    /**
     * Shortcut for string translation.
     * 
     * @return string
     */
    public function translate()
    {
        /** Get view **/
		$view = $this->getView();
        $methodArgs = func_get_args();
		return call_user_func_array(array($view, 'translate'), $methodArgs);
    }
    
    /**
     * Generates an url given the name of a route.
     *
     * @access public
     *
     * @param  array $urlOptions Options passed to the assemble method of the Route object.
     * @param  mixed $name The name of a Route to use. If null it will use the current Route
     * @param  bool $reset Whether or not to reset the route defaults with those provided
     * @return string Url for the link href attribute.
     */
    public function url($urlOptions = array(), $name = 'default', $reset = false, $encode = true)
    {
        $urlOptions = !is_array($urlOptions) ? array() : $urlOptions;
        return $this->getView()->url($urlOptions, $name, $reset, $encode);
    }

    /**
     * Get all created form elements and convert them
     * to a display group-ready array.
     * 
     * @return array
     */
    protected function _getElementsReadyForDisplayGroup()
    {
        $formElements = $this->getElements();
        $readyArray = array();
        
        foreach ($formElements as $element)
        {
            $readyArray[] = $element->getName();
        }
        
        return $readyArray;
    }
    
    /**
     * Get extension of file.
     * 
     * @param string $file
     * @return string
     */
    protected function _getFileExtension($file = null)
    {
        if(empty($file)) return '';
        $pathinfo = pathinfo($file);
        $extension = @$pathinfo['extension'];
        return $extension;
    }
    
    /**
     * Get common settings.
     * 
     * @return Zend_Config_Ini
     */
    protected function _getSettings()
    {
        return Zend_Registry::get('COMMON_SETTINGS');
    }
    
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
        parent::addDisplayGroup($elements, $name, $options);
        
        $this->getDisplayGroup($name)
             ->clearDecorators()
             ->addDecorator('FormElements');
        
        return $this;
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
        $element = parent::createElement($type, $name, $options);
        
        $cssClasses = $element->getAttrib('class');
        
        if (!empty($cssClasses)) {
            $element->setAttrib('class', $cssClasses . ' ui-corner-all');
        } else {
            $element->setAttrib('class', 'ui-corner-all');
        }
        
        $descriptionDecorator = $element->getDecorator('description');
        if ($descriptionDecorator) {
            $descriptionDecorator->setOption('class', 'description ui-corner-all');
        }
        
        $formErrorsDecorator = $element->getDecorator('errors');
        if ($formErrorsDecorator) {
            $formErrorsDecorator->setOption('class', 'errors ui-corner-all');
        }
        
        return $element;
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
                        ->removeDecorator('DtDdWrapper');
        return $this->addElement($element);
    }
    
    /**
     * Create CSRF protection element.
     * 
     * @param int $timeout 
     * @return Zend_Form
     */
    protected function _createHash($timeout = null)
    {
        $element = $this->createElement('hash', 'csrf')
                        ->setIgnore(true)
                        ->setSalt(__FILE__)
                        ->setTimeout(isset($timeout) ? $timeout : self::CSRF_TIMEOUT)
                        ->removeDecorator('Label');
                        
        $this->addElement($element);
        
        $this->csrf->getValidator('Identical')
                   ->setMessage(
                       $this->translate('Request blocked'), Zend_Validate_Identical::NOT_SAME
                   )
                   ->setMessage(
                       $this->translate('Request blocked'), Zend_Validate_Identical::MISSING_TOKEN
                   );
        
        return $this;
    }
    
    /**
     * Create description.
     * 
     * @param string $name
     * @param string $description
     * @return Zend_Form_Element_Text
     */
    protected function _createDescription($name = null, $description = null)
    {
        if (null === $name or null === $description) {
            return $this;
        }
        
        $element = $this->createElement('text', $name)
                        ->setIgnore(true)
                        ->setRequired(false)
                        ->setDescription($description)
                        ->clearDecorators()
                        ->addDecorator('description');
                        
        return $element;
    }
    
    /**
     * Get current user id.
     * 
     * Get the id attribute saved in the Zend_Auth session storage.
     * 
     * @return int|null
     * @throws Zend_Form_Exception
     */
    protected function _getUserId()
    {
        $userId = Zend_Auth::getInstance()->getIdentity()->id;
        
        if (empty($userId)) {
            throw new Zend_Form_Exception('User is not authenticated');
        }
        return $userId;
    }
}
