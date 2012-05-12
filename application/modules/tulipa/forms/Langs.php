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
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Langs.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Language form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Langs extends Tulipa_Form_Abstract
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
        $iconsPath = $this->_getSettings()->langs->iconsPath;
        /** Temp destination. **/
        $tempPath = $this->_getSettings()->tempPath . '/langs';
        /** Destination for direct upload. **/
        $langsPath = $this->_getSettings()->langs->path;
        
        $langName = strtolower(Zend_Filter::filterStatic(
                            Zend_Controller_Front::getInstance()->getRequest()
                                                                ->getPost('name'), 'alnum'));
                                                                
        $elements[] = $this->_createDescription('headDescription', 
                                                $this->translate('From here you can add new languages'));
                                  
        $elements[] = $this->createElement('text', 'title')
                           ->addFilters(array(
                                'StringTrim', 'StripTags'
                           ))
                           ->setRequired(true)
                           ->setLabel($this->translate('Name'));
        
        $elements[] = $this->createElement('text', 'name')
                           ->setRequired(true)
                           ->addFilter('alnum')
                           ->setDescription($this->translate('Example: bg, en, de'))
                           ->setLabel($this->translate('Initials'));
        
        $elements[] = $this->createElement('file', 'icon')
                           ->setDestination($iconsPath)
                           ->setLabel($this->translate('Icon'))
                           ->setDescription($this->translate("Allowed jpg, png and gif images in sizes up to 16x16"))
                           ->addValidator('Count', false, 1)
                           ->addValidator('ImageSize', false, array('maxheight' => 16, 'maxwidth' => 16))
                           ->addValidator('IsImage', false)
                           ->addValidator('Extension', false, 'jpg,png,gif')
                           ->setRequired(false);
        
        $elements[] = $this->createElement('file', 'entirePhp')
                           ->setDestination($tempPath . '/entire/php')
                           ->setLabel($this->translate('Complete translation of the PHP source code'))
                           ->addValidator('Count', false, 1)
                           ->addValidator('Extension', false, 'mo')
                           ->setRequired(false);
                           
        $elements[] = $this->createElement('file', 'entireJs')
                           ->setDestination($tempPath . '/entire/js')
                           ->setLabel($this->translate('Complete translation of the JavaScript source code'))
                           ->addValidator('Count', false, 1)
                           ->addValidator('Extension', false, 'mo')
                           ->setRequired(false);
                           
        $elements[] = $this->createElement('file', 'validate')
                           ->setLabel($this->translate('Zend_Validate translation'))
                           ->addValidator('Count', false, 1)
                           ->addValidator('Extension', false, 'php')
                           ->setRequired(false);
                           
        $elements[] = $this->createElement('file', 'measure')
                           ->setLabel($this->translate('Zend_Measure translation'))
                           ->addValidator('Count', false, 1)
                           ->addValidator('Extension', false, 'php')
                           ->setRequired(false);
                           
        $elements[] = $this->createElement('checkbox', 'convert')
                           ->setLabel($this->translate('Automatically convert .mo files to PHP arrays'))
                           ->setRequired(true)
                           ->setChecked(true);
                
        /** Add all elements to the form. **/
        $this->addElements($elements);
        
        $uploadDestination = $langsPath . '/' . $langName;
        
        if (!empty($langName) & !file_exists($uploadDestination)) {
            mkdir($uploadDestination);
        }
        
        $this->getElement('validate')
             ->setDestination($uploadDestination)
             ->addFilter('Rename', 'Zend_Validate.php');
             
        $this->getElement('measure')
             ->setDestination($uploadDestination)
             ->addFilter('Rename', 'Zend_Measure.php');
        
        /** Get file extension **/
        $extension = $this->_getFileExtension($this->getElement('icon')->getFileName());
        $this->getElement('icon')->addFilter('Rename', $langName . '.' . $extension);
                                
        $this->addDisplayGroup($this->_getElementsReadyForDisplayGroup(), 'language', 
                                array("legend" => $this->translate('Language'), 
                                'class' => 'ui-corner-all'));
                                
        $this->_createSubmit($this->translate('Add'));
        
    }
    
}