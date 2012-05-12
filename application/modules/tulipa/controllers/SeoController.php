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
 * @package    Tulipa_Controllers
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: SeoController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for search engine optimization settings.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @see        App_Controller_Default_Abstract
 */
class Tulipa_SeoController extends Tulipa_Controller_Action
{
    /**
     * Edit SEO settings.
     * 
     * @return void
     */
    public function indexAction()
    { 
    	$settingsModel = new Default_Model_Settings;
        $form = new Tulipa_Form_Seo;
        
        $form->populate($settingsModel->browseReadyForForm());
        $this->view->form = $form;
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$settings = $form->getValues();
        		
        		/** Iterate each setting and update it **/
        		foreach ($settings as $name => $content) {
        			$settingsModel->setName($name)
        			              ->setContent($content)
        			              ->update();
        		}
        		
        		$this->status($this->translate('Information successfully updated'));
        	}
        }
    }
}