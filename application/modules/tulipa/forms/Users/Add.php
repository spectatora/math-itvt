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
 * @version    $Id: Add.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * New user registration form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Users_Add extends Tulipa_Form_Abstract
{
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function init()
    {
        $this->setAction($this->url(array(), null));
        
        $usersModel = new Application_Model_Users;
        
        /** Username **/
        $elements[] = $this->createElement('text', 'username')
                           ->addValidators(array(
                                'alnum',
                                array('Db_NoRecordExists', false, array(
                                    'table' => $usersModel->getDbTableName(), 
                                    'field' => 'username'
                                ))
                           ))
                           ->setRequired(true)
                           ->addFilter('alnum')
                           ->setLabel($this->translate('Username'));
        
        /** E-mail **/
        $elements[] = $this->createElement('text', 'email')
                           ->addValidators(array(
                                'EmailAddress',
                                array('Db_NoRecordExists', false, array(
                                    'table' => $usersModel->getDbTableName(), 
                                    'field' => 'email'
                                ))
                           ))
                           ->setRequired(true)
                           ->setLabel($this->translate('E-mail'));
        
        /** Password **/
        $elements[] = $this->createElement('password', 'password')
                           ->setRequired(true)
                           ->setLabel($this->translate('Password'));
        
        /** First name **/
        $elements[] = $this->createElement('text', 'firstName')
                           ->setRequired(false)
                           ->addFilter('StringTrim')
                           ->setLabel($this->translate('First name'));
                           
        /** Last name **/
        $elements[] = $this->createElement('text', 'lastName')
                           ->setRequired(false)
                           ->addFilter('StringTrim')
                           ->setLabel($this->translate('Last name'));
                           
        /** Date of birth **/
        $elements[] = $this->createElement('text', 'dateOfBirth')
                           ->setRequired(false)
                           ->addFilter('StringTrim')
                           ->setLabel($this->translate('Date of birth'));
                           
        /** Genre **/
        $elements[] = $this->createElement('select', 'genre')
                           ->setRequired(false)
                           ->addMultiOptions(array(
                                null => $this->translate('Select'),
                                'male' => $this->translate('Male'),
                                'female' => $this->translate('Female')
                           ))
                           ->setLabel($this->translate('Genre'));
                           
        /** Country **/
        $elements[] = $this->createElement('select', 'countryId')
                           ->setRequired(false)
                           ->addMultiOptions($this->_getCountriesMultiSelect())
                           ->setLabel($this->translate('Country'));
                           
        /** City **/
        $elements[] = $this->createElement('select', 'cityId')
                           ->setRequired(false)
                           ->addMultiOptions($this->getCitiesMultiSelect())
                           ->setLabel($this->translate('City'));
                           
        /** Role **/
        $elements[] = $this->createElement('select', 'roleId')
                           ->setRequired(true)
                           ->addMultiOptions($this->_getRolesMultiSelect())
                           ->setLabel($this->translate('Role'));
                           
        /** Active **/
        $elements[] = $this->createElement('checkbox', 'active')
                           ->setRequired(false)
                           ->setValue(true)
                           ->setLabel($this->translate('Active'));
                           
        /** Banned **/
        $elements[] = $this->createElement('checkbox', 'banned')
                           ->setRequired(false)
                           ->setValue(false)
                           ->setLabel($this->translate('Banned'));
        
        $this->addElements($elements);
        
        $this->_createSubmit($this->translate('Create'));
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
            $multiOptions = array(null => $this->translate('Select'));
            foreach ($countries as $country)
            {
                $multiOptions[$country['id']] = ucfirst($country['name']);
            }
            return $multiOptions;
        }
    }
        
    /**
     * Generate roles select options.
     * 
     * @return array
     */
    protected function _getRolesMultiSelect()
    {
        $roles = Application_Model_Acl::browseRoles();
        
        $multiOptions = array();
        foreach ($roles as $role)
        {
            $multiOptions[$role['id']] = ucfirst($role['name']);
        }
        
        return $multiOptions;
    }
    
    /**
     * Generate cities select options.
     * 
     * @return array
     */
    public function getCitiesMultiSelect($countryId = null)
    {
        $multiOptions = array(null => $this->translate('Select'));
        if (empty($countryId)) {
            return $multiOptions;
        }
        
        $cities = Application_Model_L10n::browse('cities', array('countryId' => $countryId));
        
        if (!empty($cities)) {
            foreach ($cities as $city)
            {
                $multiOptions[$city['id']] = ucfirst($city['name']);
            }
        }
        
        return $multiOptions;
    }
}