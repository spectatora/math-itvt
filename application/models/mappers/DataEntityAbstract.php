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
 * @package    Application Mapper Models
 * @subpackage Entity
 * @copyright  Copyright (c) 2011 Sasquatch MC
 * @version    $Id$
 */

/**
 * Abstract mapper model.
 * 
 * @category   Application
 * @package    Application Mapper Models
 * @subpackage Entity
 * @copyright  Copyright (c) 2011 Sasquatch MC
 */
abstract class Application_Model_Mapper_DataEntityAbstract
{
    
    /**
     * Db Table name.
     * @var string
     */
    protected $_tableName = null;
    
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_tableGateway = null;
    
    /**
     * @var array
     */
    protected $_identityMap = array();
    
    /**
     * Constructor.
     * 
     * Set Zend_Db_Table instance.
     * 
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {
        if (is_null($tableGateway)) {
            $this->_tableGateway = new Zend_Db_Table($this->_tableName);
        } else {
            $this->_tableGateway = $tableGateway;
        }
    }
    
    /**
     * @return Zend_Db_Table_Abstract
     */
    protected function _getGateway()
    {
        return $this->_tableGateway;
    }
    
    /**
     * @param integer $id
     * @return mixed
     */
    protected function _getIdentity($id)
    {
        if (array_key_exists($id, $this->_identityMap)) {
            return $this->_identityMap[$id];
        }
    }
    
    /**
     * Set identity entry.
     * 
     * @param integer $id
     * @param mixed $entity
     * @return Application_Model_Mapper_Entity
     */
    protected function _setIdentity($id, $entity)
    {
        $this->_identityMap[$id] = $entity;
        return $this;
    }
}