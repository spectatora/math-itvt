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
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Translations.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Acl Role Translations Model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Acl
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Acl_Adapter_Roles_Translations extends Application_Model_Acl_Adapter_Abstract
{    
    /**
     * Translation id.
     * @var int
     */
    protected $_id = null;
    
    /**
     * Translation string.
     * @var string
     */
    protected $_title = null;
    
    /**
     * Acl Role id.
     * @var int
     */
    protected $_roleId = null;
    
    /**
     * Language id.
     * @var int
     */
    protected $_langId = null;
    
    /**
     * Set translation id
     * 
     * @param int $id
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setId($id = null)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    /**
     * Get translation id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set title
     * 
     * @param string $title
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setTitle($title = null)
    {
        $this->_title = (string) $title;
        return $this;
    }
    
    /**
     * Get title
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Set Acl Role id
     * 
     * @param int $roleId
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setRoleId($roleId = null)
    {
        $this->_roleId = (int) $roleId;
        return $this;
    }
    
    /**
     * Get Acl Role id
     * 
     * @return int
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }
    
    /**
     * Set language id
     * 
     * @param int $langId
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function setLangId($langId = null)
    {
        $this->_langId = (int) $langId;
        return $this;
    }
    
    /**
     * Get language id
     * 
     * @return int
     */
    public function getLangId()
    {
        return $this->_langId;
    }
        
    /**
     * Create new Acl Role translation string.
     * 
     * @return Application_Model_Acl_Adapter_Abstract
     */
    public function insert()
    {
        $this->getMapper()->insert($this);
        return $this;
    }
    
    /**
     * Get translations by Acl Role id.
     * 
     * @return array|null
     */
    public function getByRoleId()
    {
        return $this->getMapper()->getByRoleId($this);
    }
    
    /**
     * Get translations by Acl Role id and language id.
     * 
     * @return array|null
     */
    public function get()
    {
        return $this->getMapper()->get($this);
    }
    
    /**
     * Update translation by Acl Role id and language id.
     * 
     * @return int|null
     */
    public function update()
    {
        $this->getMapper()->update($this);
        return $this;
    }
}