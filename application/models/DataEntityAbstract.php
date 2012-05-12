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
abstract class Application_Model_DataEntityAbstract extends Application_Model_EntityAbstract
                                                    implements ArrayAccess, 
                                                               IteratorAggregate
{
    /**
     * Data Mapper class name.
     * @var string
     */
    protected $_mapperName = null;
    
    /**
     * Data Mapper instance.
     * @var Application_Model_Mapper_DataEntityAbstract
     */
    protected $_mapper = null;
    
    /**
     * Data fields.
     * @var array
     */
    protected $_data = null;
    
    /**
     * Temporary copy of the original data values. 
     * 
     * Needed for the reset() method.
     * 
     * @var array
     */
    protected $_defaultValues;
    
    /**
     * Model constructor.
     *
     * @param array $data Data fields with values.
     * @return void
     */
    public function __construct(array $data = null)
    {
        $this->_defaultValues = $this->_data;
        $this->setData($data);
    }
    
    /**
     * Set model data params.
     * 
     * @param array $data
     * @return Application_Model_DataEntityAbstract
     */
    public function setData(array $data = null)
    {
        if (!is_null($data)) {
            foreach ($data as $name => $value) {
                $this->{$name} = $value;
            }
        }
        
        return $this;
    }
        
    /**
     * Get mapper instance
     * @return Application_Model_Mapper_DataEntityAbstract
     */
    protected function _getMapper()
    {
        if (is_null($this->_mapper)) {
            if (null !== $this->_mapperName) {
                $this->setMapper(new $this->_mapperName);
            } else {
                throw new Zend_Exception('No Data Mapper name set');
            }
        }
        
        return $this->_mapper;
    }
    
    /**
     * Set new Data Mapper instance.
     *
     * @param Application_Model_Mapper_Entity $mapper
     */
    public function setMapper(Application_Model_Mapper_DataEntityAbstract $mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    
    /**
     * Get data.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_data;
    }
    
    /**
     * Set to null all the fields.
     * 
     * @return Application_Model_DataEntityAbstract
     */
    public function reset()
    {
        $this->_data = $this->_defaultValues;        
        return $this;
    }
    
    /**
     * Set row field value
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     * @throws Application_Model_Exception if the specified field is not
     *                                     found in the $_data array
     */
    public function __set($name, $value)
    {
        if (! array_key_exists($name, $this->_data)) {
		return;
/*
		throw new Application_Model_Exception(
                    'You cannot set new properties' . ' on this object');
*/
        }
        $this->_data[$name] = $value;
    }
    
    /**
     * Retrieve row field value
     *
     * @param  string $name The user-specified field name.
     * @return string       The corresponding field value.
     * @throws Application_Model_Exception if the specified field is not
     *                                     found in the $_data array
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        } else {
            throw new Application_Model_Exception("Specified field \"$name\" is not in the row");
        }
    }
    
    /**
     * Test existence of row field
     *
     * @param  string $name The field
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }
    
    /**
     * Unset row field value
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        if (isset($this->_data[$name])) {
            $this->_data[$name] = null;
        }
    }
    
    /**
     * Proxy to __isset
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }
    
    /**
     * Proxy to __get
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @return string
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }
    
    /**
     * Proxy to __set
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }
    
    /**
     * Proxy to __unset
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        return $this->__unset($offset);
    }
    
    /**
     * Required by the IteratorAggregate implementation.
     *
     * @see IteratorAggregate::getIterator()
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator((array) $this->_data);
    }
}

