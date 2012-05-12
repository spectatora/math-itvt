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
 * @package    Application_Models
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License v3
 * @version    $Id: Translate.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Translate value model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Language
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License v3
 */
class Application_Model_Translate
{
    /**
     * Translate value
     * 
     * @param string $value
     * @return string
     */
    static public function translate($value)
    {
		$view = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view;
        
        return $view->translate($value);
    }
}