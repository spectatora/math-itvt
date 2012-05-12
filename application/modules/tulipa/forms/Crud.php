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
 * @version    $Id: Crud.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD module form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Crud extends Tulipa_Form_Abstract
{
    
    /**
     * Elements for the multilingual subforms.
     * 
     * @var Zend_Config
     */
    protected $_langElements = null;

    /**
     * Set Tulipa_Form_Crud::$_langElements
     *
     * @param Zend_Config $langElements
     * @return Tulipa_Form_Crud
     */
    public function setLangElements(Zend_Config $langElements = null)
    {
        $this->_langElements = $langElements;
        return $this;
    }

    /**
     * Get Tulipa_Form_Crud::$_langElements
     *
     * @return Zend_Config
     */
    public function getLangElements()
    {
        return $this->_langElements;
    }
    
    /**
     * Constructor
     *
     * Registers form view helper as decorator
     *
     * @param mixed $options
     * @return void
     */
    public function __construct($options = null)
    {
        $this->addPrefixPath('Application_Form_Element', 
        					 'Application/Form/Element/', 
        					 'element');
        
        $this->addElementPrefixPath('Application_Filter', 'Application/Filter/', 'filter');
        
        parent::__construct($options);
    }
    
    /**
     * @see Zend_Form::init()
     */
    public function init()
    {
        $this->setAction($this->url(array('request' => 'ajax'), 'crud'))
             ->setMethod('post');
    }
    
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function initElements()
    {        
                
        if (null !== $this->_langElements) {
            
            $translations = new Tulipa_Form_Crud_Subform;            
            $translations->clearDecorators()->addDecorator('FormElements');
            
            $languages = Application_Model_Language::getInstance()->browse();
            
            foreach ($languages as $language) 
            {
                $langSubForm = new Tulipa_Form_Crud_Subform($this->getLangElements());
                $langSubForm->getDecorator('fieldset')->setLegend($language['title']);
                $langSubForm->removeDecorator('DtDdWrapper');
                
                $translations->addSubForm($langSubForm, (string) $language['id']);                
            }
            
            $this->addSubForm($translations, 'translations');

        }
    }
}