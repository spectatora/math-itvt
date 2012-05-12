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
 * @package    Tulipa_Models
 * @subpackage Notifications
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Notifications.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Notification messages model. Implements BREAD ({@see Application_Bread_Interface})
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage Notifications
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Model_Notifications extends Tulipa_Model_Abstract
                                 implements Application_Bread_Interface
{
	/**
     * @var int
     */
    protected $_id = null;

    /**
     * @var string
     */
    protected $_title = null;
    
    /**
     * @var string
     */
    protected $_content = null;

    /**
     * @var int
     */
    protected $_isViewed = null;

    /**
     * Set Tulipa_Model_Notifications::$_id
     * 
     * @param int $id
     * @return Tulipa_Model_Notifications
     */
    public function setId($id = null)
    {
        if (null === $id) {
            $this->_id = null;
            return $this;
        }
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Get Tulipa_Model_Notifications::$_id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Tulipa_Model_Notifications::$_title
     * 
     * @param string $title
     * @return Tulipa_Model_Notifications
     */
    public function setTitle($title = null)
    {
        if (null === $title) {
            $this->_title = null;
            return $this;
        }
        $this->_title = (string) $title;
        return $this;
    }

    /**
     * Get Tulipa_Model_Notifications::$_title
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }    

    /**
     * Set Tulipa_Model_Notifications::$_content
     * 
     * @param string $content
     * @return Tulipa_Model_Notifications
     */
    public function setContent($content = null)
    {
        if (null === $content) {
            $this->_content = null;
            return $this;
        }
        $this->_content = (string) $content;
        return $this;
    }

    /**
     * Get Tulipa_Model_Notifications::$_content
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Set Tulipa_Model_Notifications::$_isViewed
     * 
     * @param int $isViewed
     * @return Tulipa_Model_Notifications
     */
    public function setIsViewed($isViewed = null)
    {
        if (null === $isViewed) {
            $this->_isViewed = null;
            return $this;
        }
        $this->_isViewed = (int) $isViewed;
        return $this;
    }

    /**
     * Get Tulipa_Model_Notifications::$_isViewed
     * 
     * @return int
     */
    public function getIsViewed()
    {
        return $this->_isViewed;
    }
    
    public function browse($returnArray = false)
    {
        return $this->getMapper()->browse($this, $returnArray);
    }
    
    public function read()
    {
        $row = $this->getMapper()->read($this);
        $this->setOptions($row);
        return $row;
    }
    
    public function update()
    {
    	$this->getMapper()->update($this);
        return $this;
    }
    
    public function insert()
    {
        $id = $this->getMapper()->insert($this);
        $this->setId($id);
        return $this;
    }
    
    public function delete()
    {
        $this->getMapper()->delete($this);
        return $this;
    }
    
    /**
     * Create new notification.
     * 
     * @param string $title
     * @param string $content
     * @return void
     * @throws Zend_Exception when $content is null
     */
    public static function create($title = null, $content = null)
    {
        if (null === $content) {
            throw new Zend_Exception('Notification content not specified');
        }
        
        if (!is_string($content)) {
            throw new Zend_Exception('$content have to be string');
        }
        
        $options = array('title' => $title, 'content' => $content);
        self::getInstance()->setOptions($options)->insert();
    }
    
    /**
     * Check notification existance.
     * 
     * Check by notification id. Return true if notification is avaliable.
     * 
     * @param int $id
     * @return boolean
     */
    public static function isNotificationExisting($id = null)
    {
        $notification = self::getInstance()->setId($id)->read();
        
        if (empty($notification)) {
            return false;
        }
        
        return true;
    }
}