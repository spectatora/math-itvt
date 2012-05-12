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
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Seo.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * SEO form.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Form_Seo extends Tulipa_Form_Abstract
{
    /**
     * Create form elements. 
     * 
     * @return void
     */
    public function init()
    {
        $this->setAction($this->url(array(), null));
                
        /** SEO Description **/
        $elements[] = $this->createElement('textarea', Default_Model_Settings::SETTING_SEO_DESCRIPTION)
                           ->setRequired(true)
                           ->addFilters(array('StringTrim', 'StripTags'))
                           ->setAttrib('rows', 5)
                           ->setLabel($this->translate('Description'));
        
        /** SEO keywords **/
        $elements[] = $this->createElement('text', Default_Model_Settings::SETTING_SEO_KEYWORDS)
                           ->setRequired(true)
                           ->addFilters(array('StringTrim', 'StripTags'))
                           ->setLabel($this->translate('Keywords'));
        
        /** SEO robots.txt file content **/
        $elements[] = $this->createElement('textarea', Default_Model_Settings::SETTING_SEO_ROBOTS)
                           ->setRequired(true)
                           ->addFilters(array('StringTrim', 'StripTags'))
                           ->setAttrib('rows', 5)
                           ->setLabel($this->translate('robots.txt'));
                
        $this->addElements($elements);
        
        $this->_createSubmit($this->translate('Update'));
    }
}