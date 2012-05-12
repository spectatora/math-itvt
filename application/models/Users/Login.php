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
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Login.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Users model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Users_Login extends Application_Model_Abstract
{
    /**
     * @var string
     */
    protected $_identity = null;

    /**
     * @var string
     */
    protected $_credential = null;

    /**
     * Set Application_Model_Users_Login::$_identity
     * 
     * @param string $identity
     * @return Application_Model_Users_Login
     */
    public function setIdentity($identity = null)
    {
        $this->_identity = (string) $identity;
        return $this;
    }

    /**
     * Get Application_Model_Users_Login::$_identity
     * 
     * @return string
     */
    public function getIdentity()
    {
        return $this->_identity;
    }

    /**
     * Set Application_Model_Users_Login::$_credential
     * 
     * @param string $credential
     * @return Application_Model_Users_Login
     */
    public function setCredential($credential = null)
    {
        $this->_credential = (string) $credential;
        return $this;
    }

    /**
     * Get Application_Model_Users_Login::$_credential
     * 
     * @return string
     */
    public function getCredential()
    {
        return $this->_credential;
    }
    
    /**
     * Make a login attempt.
     * 
     * @return Application_Model_Users_Login
     */
    public function attempt()
    {
        $usersModel = new Application_Model_Users;
        
        $auth = Zend_Auth::getInstance();
        
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table_Abstract::getDefaultAdapter(),
			$usersModel->getDbTableName(Application_Model_Users::DATA_MAPPER_VIEW_SUFFIX),
			'username',
			'password'
		);
        
		$authAdapter->setIdentity($this->getIdentity())
			        ->setCredential(md5($this->getCredential()));
							
        /** Get session auth storage. **/
        $storage = $auth->getStorage();
		
		/** Try to authenticate. **/
		$result = $auth->authenticate($authAdapter);
        
        if ($result->isValid()) {            
            $acl = Zend_Registry::get('Zend_Acl');
            
            $resource = Zend_Controller_Front::getInstance()->getRequest()->getModuleName() 
                        . Application_Model_Acl::HIERARCHY_SEPARATOR;
            
            $resultObject = $authAdapter->getResultRowObject();
            $roleName = $resultObject->roleName;
            
            /**
             * User doesn't have permissions.
             */
            if (!$acl->isAllowed($roleName, $resource)) {
                $this->addError($this->translate('This user does not have sufficient privileges'));
                $auth->clearIdentity();
                return $this;
            }                    
            
            /**
             * User not active.
             */
            if (!$resultObject->active) {
                $this->addError($this->translate('User is not activated'));
                $auth->clearIdentity();
                return $this;
            }
            
            /**
             * User banned.
             */
            if($resultObject->banned) {
                $this->addError($this->translate('User is blocked'));
                $auth->clearIdentity();
                return $this;
            }
            
            $storage->write($resultObject);
            
            /**
             * Generate new session id.
             */
            Zend_Session::regenerateId();
        } else {
            $this->addError($this->translate('Wrong username or password'));
        }
        
        return $this;
    }
}