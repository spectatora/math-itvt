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
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Abstract.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Abstract class for models.
 * 
 * @category   Application
 * @package    Application_Models
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
abstract class Application_Model_Abstract
{
    
    /**
     * Singleton instances
     *
     * @var array
     */
    protected static $_instances = array();
    
    /**
     * Model class name prefix.
     */
    const MODEL_NAMESPACE = 'Model_';
    
    /**
     * Data mapper class name prefix.
     */
    const DATA_MAPPER_MODEL_NAMESPACE = 'Model_Mapper_';
    
    /**
     * @var string
     */
    protected $_classNamespace = 'Application_';
    	
    /**
     * @var Application_Model_Mapper_Abstract
     */
    protected $_mapper;
    
    /**
     * Data mapper class name suffix.
     * @deprecated
     * @var string
     */
    protected $_dataMapperClassNameSuffix = null;
    
    /**
     * Data mapper class name.
     * @var string
     */
    protected $_dataMapperClassName = null;
    
    /**
     * @var Zend_Config_Ini
     */
    protected $_commonSettings = null;
    
    /**
     * @var array
     */
    protected $_errors = null;
    
    /**
     * Returns an instance of Application_Model_Abstract
     *
     * Singleton pattern implementation
     *
     * @return Application_Model_Abstract Provides a fluent interface
     */
    public static function getInstance()
    {
        $calledClassName = get_called_class();
        if (empty(self::$_instances[$calledClassName])) {
            self::$_instances[$calledClassName] = new $calledClassName();
        }
        
        return self::$_instances[$calledClassName];
    }
    
    /**
     * Constructor.
     * 
     * Sets model options.
     * 
     * @param  array|null|string $options   If $options is string, it's 
     *                                      assumed for option key
     * @return void
     */
    public function __construct($options = null)
    {
        
        /** Load common settings **/
        $this->_commonSettings = Zend_Registry::get('COMMON_SETTINGS');
        
        if (func_num_args() > 1) {
            if (is_string($options)) {
                $key = $options;
                $value = func_get_arg(1);
                $this->{$key} = $value;
                return;
            }
        }
        
        if (is_array($options)) {
            $this->setOptions($options);
        }
                
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    
    
    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Zend_Exception('Invalid property specified');
        }
        return $this->$method();
    }
    
    /**
     * Get object attributes as array.
     * 
     * @param boolean $passEmpty
     * @param array $exceptions
     * @param array $allowed If is set, it has more power than $exceptions.
     * @return array|null
     */
    public function toArray($passEmpty = true, $exceptions = array('mapper', 'errors'), $allowed = null)
    {
        $methods = get_class_methods($this);
        $methodPattern = '@^set([a-zA-Z0-9]+)$@';
        foreach ($methods as $method) {
            if (preg_match($methodPattern, $method, $matches)) {
                $methodShortName = $matches[1];
                $getMethodName = 'get' . $methodShortName;
                /** Check is allowed **/
                if (is_array($allowed)) {
                    if (in_array(lcfirst($methodShortName), $allowed) & 
                        in_array($getMethodName, $methods)) {
                            
                        $methodReturnValue = $this->$getMethodName();                    
                        
                        if ($passEmpty & !isset($methodReturnValue)) {
                            /** Pass the empty variables. **/
                            continue;
                        }
                        $resultArray[lcfirst($methodShortName)] = $methodReturnValue;
                    }
                } else {
                    /** Check the exceptions. **/
                    if (!in_array(lcfirst($methodShortName), $exceptions) & 
                        in_array($getMethodName, $methods)) {
                            
                        $methodReturnValue = $this->$getMethodName();                    
                        
                        if ($passEmpty & !isset($methodReturnValue)) {
                            /** Pass the empty variables. **/
                            continue;
                        }
                        $resultArray[lcfirst($methodShortName)] = $methodReturnValue;
                    }
                }
            }
        }
        
        return isset($resultArray) ? $resultArray : null;
    }
    
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Application_Model_Abstract
     */
    public function setOptions($options)
    {
        if (empty($options)) {
            return $this;
        }
        
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    /**
     * Clear object options
     * 
     * @param  array $allowed Array of fixed attributes to unset.
     * @return Application_Model_Abstract
     */
    public function clearOptions($allowed = null)
    {
        $attributes = get_class_vars(get_class($this));
        $matchPattern = '@^_(.+)$@';
        foreach ($attributes as $name => $value) {
            if (preg_match($matchPattern, $name, $optionName)) {
                if (method_exists($this, 'set' . ucfirst($optionName[1]))) {
                    if (is_array($allowed)) {
                        if (in_array($optionName[1], $allowed)) {
                            $this->$name = null;
                        }
                    } else {
                        $this->$name = null;
                    }
                }
            }
        }
        return $this;
    }
    
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Application_Model_Abstract
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     * Loads mapper instance if no mapper registered.
     * 
     * @param string $mapperName
     * @return Application_Model_Mapper_Abstract|void
     */
    public function getMapper($mapperName = null)
    {
        if (null !== $mapperName) {
            $className = $this->_classNamespace . self::DATA_MAPPER_MODEL_NAMESPACE . ucfirst($mapperName);
            return new $className;
        }
        
        if (null === $this->_mapper) {
            if (null === $this->_dataMapperClassName) {
                $className = str_replace($this->_classNamespace . self::MODEL_NAMESPACE, '', get_class($this));
                $dataMapperClassName = $this->_classNamespace . self::DATA_MAPPER_MODEL_NAMESPACE . ucfirst($className);
            } else {
                $dataMapperClassName = $this->_dataMapperClassName;
            }
            $this->setMapper(new $dataMapperClassName);
        }
        return $this->_mapper;
    }
    
    /**
     * Translate value
     * 
     * @return string
     */
    public function translate()
    {
        /** Get view **/
		$view = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view;
		$arguments = func_get_args();
		return call_user_func_array(array($view, 'translate'), $arguments);
    }
    
    /**
     * Calls the url view helper.
     * 
     * @param  array $urlOptions Options passed to the assemble method of the Route object.
     * @param  mixed $name The name of a Route to use. If null it will use the current Route
     * @param  bool $reset Whether or not to reset the route defaults with those provided
     * @return string
     */
    public function url(array $urlOptions = array(), $name = null, $reset = true, $encode = true)
    {
        $urlHelper = new Zend_View_Helper_Url();
        
        return $urlHelper->url($urlOptions, $name, $reset, $encode);
    }
    
    /**
     * Get Db Table name.
     * 
     * @param string $mapperName
     * @return string
     */
    public function getDbTableName($mapperName = null)
    {
        return $this->getMapper($mapperName)->getDbTable()->info('name');
    }
    
    /**
     * Clear Application_Model_Abstract::$_errors
     * 
     * @return Application_Model_Abstract
     */
    public function clearErrors()
    {
        unset($this->_errors);
        return $this;
    }
    
    /**
     * Set Application_Model_Abstract::$_errors
     * 
     * Set error messages.
     * 
     * @param array $errors
     * @return Application_Model_Abstract
     */
    public function setErrors($errors = null)
    {
        $this->_errors = (array) $errors;
        return $this;
    }

    /**
     * Get Application_Model_Abstract::$_errors
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
    
    /**
     * Add new error message.
     * 
     * @param string $message
     * @return Application_Model_Abstract
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
    
    /**
     * Get application.ini configuration.
     * 
     * @return array
     */
    public function getApplicationConfig()
    {
        $options = Zend_Controller_Front::getInstance()
                                        ->getParam('bootstrap')
                                        ->getApplication()
                                        ->getOptions();
        return $options;
    }
        
    /**
     * Calculates the percent based on value and maxvalue.
     *
     * @param int $val - Current value
     * @param int $maxVal - Total value
     * @return float - percent of total value
     */
    public static function calcPercent($val = null, $maxVal = null)
    {
        $maxval = (float) $maxVal;
        if (0 == $maxVal) {
            return 0;
        }
        
        return (float) $val / $maxVal * 100;
    }
}