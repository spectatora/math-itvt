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
 * @category   Default
 * @package    Default_Controllers
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: SeoController.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * SEO controller.
 * 
 * Used to show robots.txt
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Default
 * @package    Default_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class SeoController extends Default_Controller_Action
{
	/**
	 * Output robots.txt for SEO.
	 * 
	 * @return void
	 */
    public function robotsTxtAction()
    {
    	/** View and layout are not needed **/
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        /** Document must be excepted as a plain text **/
        header('Content-Type: text/plain');
    	
		$seoRobotsTxt = Default_Model_Settings::readFieldByName(
	       'content', Default_Model_Settings::SETTING_SEO_ROBOTS
	    );
	    
	    $this->getResponse()
	         ->setBody($seoRobotsTxt);
    }
}