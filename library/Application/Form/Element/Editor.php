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
 * @subpackage Elements
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Editor.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Textarea element with css class for CKEditor.
 * 
 * @category   Tulipa
 * @package    Tulipa_Forms
 * @subpackage Elements
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Form_Element_Editor extends Zend_Form_Element_Textarea
{
    const CSS_CLASS = 'ckeditor-replace';
    
    /**
     * Add the css class, that will be used by jQuery to replace
     * textarea with CKEditor instance.
     * 
     * @return void
     * @see Zend_Form_Element::init()     * 
     */
    public function init()
    {
        $this->setAttrib('class', self::CSS_CLASS);
    }
    
}
