<?php
/**
 * phpAbility © 
 * Copyright © 2011 Sasquatch <Joan-Alexander Grigorov>
 *                      http://bgscripts.com
 * 
 * LICENSE
 * 
 * A copy of this license is bundled with this package in the file LICENSE.txt.
 * 
 * Copyright © phpAbility
 * 
 * Platform that uses this site is protected by copyright. 
 * It is provided solely for the use of this site and all its copying, 
 * processing or use of parts thereof is prohibited and pursued by law.
 * 
 * All rights reserved. Contact: office@bgscripts.com
 *
 * @category   Application
 * @package    Application Models
 * @subpackage Entity
 * @copyright  Copyright (c) 2011 Sasquatch MC
 * @version    $Id$
 */

/**
 * Abstract model.
 * 
 * @category   Application
 * @package    Application Models
 * @subpackage Entity
 * @copyright  Copyright (c) 2011 Sasquatch MC
 */
abstract class Application_Model_EntityAbstract
{
    
    /**
     * Errors array.
     * @var array|null
     */
    protected $_errors = null;
    
    /**
     * Set Application_Model_EntityAbstract::$_errors
     *
     * Set error messages.
     *
     * @param array $errors
     * @return Application_Model_EntityAbstract
     */
    public function setErrors($errors = null)
    {
        $this->_errors = (array) $errors;
        return $this;
    }
    
    /**
     * Get Application_Model_EntityAbstract::$_errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
        
    /**
     * Clear Application_Model_EntityAbstract::$_errors
     *
     * @return Application_Model_EntityAbstract
     */
    public function clearErrors()
    {
        unset($this->_errors);
        return $this;
    }
    
    /**
     * Add new error message.
     *
     * @param string $message
     * @return Application_Model_EntityAbstract
     */
    public function addError($message = null)
    {
        if (!empty($message)) {
            $this->_errors[] = $message;
        }
        return $this;
    }
    
    /**
     * Check if any errors were registered.
     *
     * @return boolean
     */
    public function hasErrors()
    {
        if (empty($this->_errors)) {
            return false;
        }
        return true;
    }
        
}