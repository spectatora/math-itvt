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
 * @subpackage Login
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: LoginController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Login controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Login
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_LoginController extends Tulipa_Controller_Action
{
    /**
     * Login form and login proccess.
     * 
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_Login;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            
            if ($form->isValid($request->getPost())) {
                
                $loginModel = new Application_Model_Users_Login(array(
                    'identity' => $form->getValue('username'),
                    'credential' => $form->getValue('password')
                ));
                
                /** Make a login attempt. **/
                $loginModel->attempt();
                
                /** Check for errors. **/
                if ($loginModel->hasErrors()) {
                    $this->getHelper('Status')->addErrors($loginModel->getErrors());
                    return;
                } else {
                    /** If login attempt is successful - redirect to index. **/
                    $this->_helper->redirector->gotoRouteAndExit(array(
                            'controller' => 'index',
                            'action' =>'index'
                        ), 'tulipa', true
                    );
                }
            }
            
        }
        
    }
}