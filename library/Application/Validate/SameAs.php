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
 * @package    Application_Validate
 * @subpackage SameAs
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: SameAs.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Checks if a field has the same value as another.
 * 
 * @category   Application
 * @package    Application_Validate
 * @subpackage SameAs
 * @author     Tudor Barbu <miau@motane.lu>
 * @license    MIT - http://www.opensource.org/licenses/mit-license.php
 */
class Application_Validate_SameAs extends Zend_Validate_Abstract 
{
	/**
	 * Validation failure message key for when the values are not
	 * the same
	 */
	const NOT_SAME = 'notSame';

	/**
	 * the external element that we check the value against 
	 *
	 * @var Zend_Form_Element
	 */
	protected $_element;

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_SAME => 'The two values are not identical',
    );

	/**
	 * Can receive a Zend_Form_Element parameter that will be used
	 * into the validation process
	 *
	 * @param array $options
	 */
	public function __construct($options) {
	          
		if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if (is_array($options)) {
            
            if (array_key_exists('element', $options)) {
                $element = $options['element'];
            } else {
                throw new Zend_Validate_Exception("Missing option 'pattern'");
            }
            
            if (array_key_exists('messageTemplates', $options)) {
                $messageTemplates = $options['messageTemplates'];
                $this->setMessages($messageTemplates);
            }
        }

        $this->setElement($element);
        
	}

	/**
	 * set the element
	 *
	 * @param Zend_Form_Element $element
	 * @return void
	 */
	public function setElement(Zend_Form_Element $element) {
		$this->_element = $element;
	}

	/**
	 * gets the element
	 *
	 * @return Zend_Form_Element
	 */
	public function getElement() {
		return $this->_element;
	}

	/**
	 * overrides isValid from Zend_Validate_Interface
	 *
	 * @param string $value
	 * @return bool
	 */
	public function isValid($value) {
        if(null === $this->_element) {
        	throw new Zend_Exception('You must add a Zend_Form_Element to the SameAs validator prior to calling the isValid() method');
        }

		if($value != $this->_element->getValue()) {
			$this->_error(self::NOT_SAME);
			return false;
		}

		return true;
	}
}
?>