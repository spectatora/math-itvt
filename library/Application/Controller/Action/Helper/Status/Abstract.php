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
 * @package    Application_Controllers
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Abstract.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller helper for status reportings.
 * 
 * @category   Application
 * @package    Application_Controllers
 * @subpackage Helpers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
abstract class Application_Controller_Action_Helper_Status_Abstract extends 
    Zend_Controller_Action_Helper_Abstract
{
    /**
     * Contains all status messages.
     * @var array
     */
    protected $_statusMessages = array();
        
    /**
     * Strategy pattern: call helper as helper broker method.
     * 
     * Add status message to the containing array.
     * 
     * @param string|null $statusMessage
     * @param string $statusType
     * @param boolean $isError
     * @return void
     */
    public function direct($statusMessage = null, $statusType = 'success', $isError = false)
    {
        return $this->addStatusMessage($statusMessage, $statusType, (boolean) $isError);
    }
    
    /**
     * Add status message to the containing array.
     * 
     * @param string|null $statusMessage
     * @param string $statusType
     * @param boolean $isError
     * @return void
     */
    public function addStatusMessage($statusMessage = null, $statusType = 'success', $isError = false)
    {
        if (null === $statusMessage) {
            return;
        }
        
        $this->_statusMessages[] = array(
            'type' => Zend_Filter::filterStatic($statusType, 'alnum'),
            'message' => (string) $statusMessage,
            'isError' =>  (boolean) $isError
        );
        
        /**
         * Update the status messages in the action controller view.
         */
        $this->getActionController()->view->statusMessages = $this->_statusMessages;
        
        return $this;
    }
    
    /**
     * Get all registered status messages.
     * 
     * @return array|null
     */
    public function getStatusMessages()
    {
        return $this->_statusMessages;
    }
    
    /**
     * Add errors.
     * 
     * @return 
     */
    public function addErrors(array $errors = null)
    {
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->addStatusMessage($error, 'error', true);
            }
        }
        return $this;
    }
}