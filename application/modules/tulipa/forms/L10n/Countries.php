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
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Countries.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Countries form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_L10n_Countries extends Tulipa_Form_Abstract
{   
    /**
     * Create form elements.
     *
     * @return void
     */ 
    public function init()
    {
        $this->setMethod('post')
             ->setAction($this->url(array('request' => 'ajax'), null));
        
        /** Destination to upload icons. **/
        $iconsPath = $this->_getSettings()->l10n->iconsPath;
        /** Temp destination. **/
        $tempPath = $this->_getSettings()->tempPath . '/l10n';
        
        $countryCode = strtolower(Zend_Filter::filterStatic(
                            Zend_Controller_Front::getInstance()->getRequest()
                                                                ->getPost('code'), 'alnum'));
                                                                
        $elements[] = $this->_createDescription('headDescription', 
                                                $this->translate('From here you can add new country'));
                                  
        $elements[] = $this->createElement('text', 'name')
                           ->addFilters(array(
                                'StringTrim', 'StripTags'
                           ))
                           ->setRequired(true)
                           ->setLabel($this->translate('Name'));
        
        $elements[] = $this->createElement('text', 'code')
                           ->addValidator('alnum')
                           ->setRequired(true)
                           ->setDescription($this->translate('Example: bg, en, de'))
                           ->setLabel($this->translate('Initials'));
        
        $elements[] = $this->createElement('file', 'icon')
                           ->setDestination($iconsPath)
                           ->setLabel($this->translate('Icon'))
                           ->setDescription($this->translate('Allowed jpg, png and gif images in sizes up to 16x16'))
                           ->addValidator('Count', false, 1)
                           ->addValidator('ImageSize', false, array('maxheight' => 16, 'maxwidth' => 16))
                           ->addValidator('IsImage', false)
                           ->addValidator('Extension', false, 'jpg,png,gif')
                           ->setRequired(false);
        
        $elements[] = $this->createElement('select', 'langId')
                           ->addFilter('int')
                           ->addMultiOptions($this->_getLanguagesMultiSelect())
                           ->setValue(null)
                           ->setRequired(false)
                           ->setLabel($this->translate('Official language'));
                
        /** Add all elements to the form. **/
        $this->addElements($elements);
        
        /** Get file extension **/
        $extension = $this->_getFileExtension($this->getElement('icon')->getFileName());
        $this->getElement('icon')->addFilter('Rename', $countryCode . '.' . $extension);
                                
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'l10n', 
                                array("legend" => $this->translate('Countries'), 
                                'class' => 'ui-corner-all'));
                                
        $this->_createSubmit($this->translate('Add'));
        
    }    
    
    /**
     * Generate languages select options.
     * 
     * @return array
     */
    protected function _getLanguagesMultiSelect()
    {
        $multiOptions = array(
            null => $this->translate('None')
        );
             
        $langs = Zend_Registry::get('LANGUAGES');
        foreach ($langs as $lang)
        {
            $multiOptions[$lang['id']] = ucfirst($lang['title']);
        }
        
        return $multiOptions;
    }
    
}