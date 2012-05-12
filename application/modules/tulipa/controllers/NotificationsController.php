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
 * @subpackage Notifications
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: NotificationsController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Notifications controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Notifications
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_NotificationsController extends Tulipa_Controller_Action
{
    /**
     * Show all notifications.
     * 
     * @return void
     */
    public function indexAction()
    {
        $notifications = Tulipa_Model_Notifications::getInstance()->browse();
        
        $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($notifications);
        
        Application_Model_Paginator::create($paginatorAdapter, $this->_getParam('id'), 'notifications');
    }
    
    /**
     * Set notification as viewed.
     * 
     * @return void
     */
    public function hideAction()
    {
        /** Disable layout and view **/
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getPost('id');
                
        /** Check notification existance **/
        if (Tulipa_Model_Notifications::isNotificationExisting($id)) {
            $notificationsModel = Tulipa_Model_Notifications::getInstance();
            $notificationsModel->setId($id)
                               ->setIsViewed(true)
                               ->update();
        }
    }
    
    /**
     * Delete notification.
     * 
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->_getParam('id');
                
        /** Notification not found **/
        if (!Tulipa_Model_Notifications::isNotificationExisting($id)) {
            $this->status($this->translate('Notice that you are trying to delete does not exist'), 
                            'error', true);
            $this->outputStatusJson();
            return;
        }
        
        Tulipa_Model_Notifications::getInstance()->setId($id)->delete();
        $this->status($this->translate('Notification successfully deleted'));
        $this->outputStatusJson();
    }
}