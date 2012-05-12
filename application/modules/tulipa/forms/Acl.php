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
 * @version    $Id: Acl.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Acl form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @uses       Application_Form_Abstract
 */
class Tulipa_Form_Acl extends Tulipa_Form_Abstract
{
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function init()
    {
        $this->setAction($this->url(array(), null))
             ->setAttrib('class', 'ruleAdd');
        
        $elements[] = $this->createElement('hash', 'csrf')
                           ->setIgnore(true)
                           ->setSalt(__FILE__)
                           ->removeDecorator('Label');
        
        $modules = Application_Model_Acl_Scanner::scanModules();
        
        $elements[] = $this->createElement('select', 'roleId')
                           ->addFilter('int')
                           ->addMultiOptions($this->_getRolesMultiSelect())
                           ->setLabel($this->translate('Role'));
        
        $elements[] = $this->createElement('select', 'module')
                           ->addFilters(array('StringTrim', 'StripTags'))
                           ->addMultiOptions($this->_getModulesMultiSelect())
                           ->setRequired(true)
                           ->setLabel($this->translate('Module'));
        
        $elements[] = $this->createElement('select', 'resource', array('registerInArrayValidator' => false))
                           ->addFilters(array('StringTrim', 'StripTags'))
                           ->addMultiOptions(array(
                                null => $this->translate('For all')
                           ))
                           ->removeValidator('InArray')
                           ->setLabel($this->translate('Section'));
        
        $elements[] = $this->createElement('select', 'privilege', array('registerInArrayValidator' => false))
                           ->addMultiOptions(array(
                                null => $this->translate('For all')
                           ))
                           ->removeValidator('InArray')
                           ->setLabel($this->translate('Subsection'));
        
        $elements[] = $this->createElement('select', 'allow')
                           ->addFilter('boolean')
                           ->addMultiOptions(array(
                                true => $this->translate('Allowed'),
                                false => $this->translate('Forbiden')
                           ))
                           ->removeValidator('InArray')
                           ->setLabel($this->translate('Access'));
        
        $this->addElements($elements);
        
        
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), __CLASS__, 
                                array("legend" => $this->translate('User access rules'), 
                                'class' => 'ui-corner-all'));
        
        $this->_createSubmit($this->translate('Create'));
        
    }
        
    /**
     * Generate modules select options.
     * 
     * @return array
     */
    protected function _getModulesMultiSelect()
    {
        $multiOptions = array(
            null => $this->translate('Select')
        );
        $modules = Application_Model_Acl_Scanner::scanModules();
        foreach ($modules as $module)
        {
            $multiOptions[$module] = ucfirst($module);
        }
        
        return $multiOptions;
    }
        
    /**
     * Generate roles select options.
     * 
     * @return array
     */
    protected function _getRolesMultiSelect()
    {
        $multiOptions = array(
            null => $this->translate('For all')
        );
        $roles = Application_Model_Acl::browseRoles();
        foreach ($roles as $role)
        {
            $multiOptions[$role['id']] = ucfirst($role['name']);
        }
        
        return $multiOptions;
    }

}