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
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Roles.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Roles form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Application_Form_Abstract
 */
class Tulipa_Form_Acl_Roles extends Tulipa_Form_Abstract
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
        
        $elements[] = $this->createElement('text', 'name')
                           ->addFilter('alnum')
                           ->addValidator('alnum')
                           ->setRequired(true)
                           ->setLabel($this->translate('Code'))
                           ->setDescription($this->translate('Allowed only Latin characters and Arabic numerals'));
        
        $elements[] = $this->createElement('select', 'parentId')
                           ->addFilter('int')
                           ->addMultiOptions($this->_getParentIdMultiSelect())
                           ->setRequired(false)
                           ->setLabel($this->translate('Parent'));
                
        $elements[] = $this->createElement('select', 'default')
                           ->addFilter('alpha')
                           ->addMultiOptions(array(
                                null => $this->translate('-'),
                                Application_Model_Acl_Adapter_Roles::DEFAULT_GUEST => $this->translate('Role by default (guest)'),
                                Application_Model_Acl_Adapter_Roles::DEFAULT_STANDART => $this->translate('Standard role (registered user)'),
                                Application_Model_Acl_Adapter_Roles::DEFAULT_SUPER => $this->translate('Super role (administrators)')
                           ))
                           ->setRequired(false)
                           ->setLabel($this->translate('Special options'))
                           ->setDescription($this->translate('Only used to mark a role as leading in it`s kind. Please do not use this field if you don`t know what you are doing!'));
        
        $languages = Application_Model_Language::getInstance()->browse();
        
        $translations = new Zend_Form_SubForm;
        $translations->clearDecorators('fieldset')->addDecorator('FormElements');
                
        foreach ($languages as $language) 
        {
            $subFormTranslationElements[] = $translations->createElement('text', (string) $language['id'])
                                                         ->addFilters(array('StringTrim', 'StripTags', new Zend_Filter_Alnum(true)))
                                                         ->setBelongsTo('translations')
                                                         ->setRequired(false)
                                                         ->setLabel(sprintf($this->translate('Name (%s)'), $language['name']));
        }
        
        $this->addElements($elements);
        
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'roles', 
                                array("legend" => $this->translate('User roles'), 
                                'class' => 'ui-corner-all'));
                                
        $this->addSubForm($translations, 'translations');
        $translations->addElements($subFormTranslationElements);
        
        $this->_createSubmit($this->translate('Create'));
        
    }    
    
    /**
     * Generate parent id select options.
     * 
     * @return array
     */
    protected function _getParentIdMultiSelect()
    {
        $roles = Application_Model_Acl::browseRoles();
        
        $multiOptions = array(
            null => $this->translate('None')
        );
        foreach ($roles as $role)
        {
            $multiOptions[$role['id']] = ucfirst($role['name']);
        }
        
        return $multiOptions;
    }

}