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
 * @subpackage Role
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Role.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Class for Acl Assertion Role.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Role
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Role implements 
    Zend_Acl_Role_Interface
{
    /**
     * @var string
     */
    protected $_roleId = null;

    /**
     * @var array
     */
    protected $_identity = null;
    
    /**
     * @var array
     */
    protected $_roleDetails = null;

    /**
     * Set Application_Model_Role::$_roleId
     * 
     * @param string $roleId
     * @return Application_Model_Role
     */
    public function setRoleId($roleId = null)
    {
        $this->_roleId = (string) $roleId;
        return $this;
    }

    /**
     * Get Application_Model_Role::$_roleId
     * 
     * @return string
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }

    /**
     * Set Application_Model_Role::$_identity
     * 
     * @param array $identity
     * @return Application_Model_Role
     */
    public function setIdentity($identity = null)
    {
        $this->_identity = (array) $identity;
        return $this;
    }

    /**
     * Get Application_Model_Role::$_identity
     * 
     * @return array
     */
    public function getIdentity()
    {
        return $this->_identity;
    }

    /**
     * Set Application_Model_Role::$_roleDetails
     * 
     * @param array $roleDetails
     * @return Application_Model_Role
     */
    public function setRoleDetails($roleDetails = null)
    {
        $this->_roleDetails = (array) $roleDetails;
        return $this;
    }

    /**
     * Get Application_Model_Role::$_roleDetails
     * 
     * @return array
     */
    public function getRoleDetails()
    {
        return $this->_roleDetails;
    }
    
    /**
     * Constructor.
     * 
     * Find user identity.
     * 
     * @return void
     */
    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            
            $this->setIdentity($auth->getIdentity());
            $this->setRoleId($auth->getIdentity()->roleName);
                        
            $this->setRoleDetails(
                Application_Model_Acl::readRoleById($auth->getIdentity()->roleId)
            );
        } else {
            
            $role = Application_Model_Acl::readRoleByDefault(
                Application_Model_Acl_Adapter_Roles::DEFAULT_GUEST
            );
            
            $this->setRoleId($role['name']);
        }
    }

}