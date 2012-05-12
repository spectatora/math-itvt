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
 * @subpackage Index
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: IndexController.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Index controller.
 * 
 * Site home page.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Default
 * @package    Default_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class IndexController extends Default_Controller_Action
{
    /**
     * Disable page cache.
     * 
     * @see Application_Controller_Action::init()
     * @return void
     */
    public function init()
    {
        Zend_Registry::get('PAGE_CACHE')->cancel();
    }
    
    /**
     * Show last news.
     * 
     * @return void
     */
    public function indexAction()
    {
       $request = $this->getRequest();
        
       $form = new Default_Form_Register;
        
       $this->view->form = $form;

	if ($request->isPost()) {
            
	    
            if ($form->isValid($request->getPost())) {


		 $model = new Default_Model_Participants($form->getValues());
		$model->save();

		   /** Check for errors. **/
                if ($model->hasErrors()) {
                    $this->getHelper('Status')->addErrors($model->getErrors());
                    return;
                } else {


/*
                    $this->_helper->redirector->gotoRouteAndExit(array(
                            'controller' => 'index',
                            'action' =>'index'
                        ), 'default', true
                    );
*/
			$this->view->message = "Успешно регистрирахте участник";
                }

            }
	}
}
}
