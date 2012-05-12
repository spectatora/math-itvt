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
 * @package    Tulipa_Crud
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Crud.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Crud handler.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Crud
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_Crud
{    
    /**
     * Cache ID for the caching mechanism.
     * 
     * @var string
     */
    const CACHE_ID = 'CRUD_MODULES';
	
	/**
	 * Registry ID for Zend_Registry
	 * 
	 * @var string
	 */
	const ZEND_REGISTRY_INDEX = 'CRUD_MODULES';
	
    /**
     * Singleton instance
     *
     * @var Tulipa_Crud
     */
    protected static $_instance = null;
    
    /**
     * Modules models instances.
	 *
     * @var array
     */
    protected static $_modulesModels;
    
    /**
     * Files model instance.
     * 
     * @var array
     */
    protected static $_filesModel;
    
    /**
     * Pictures model instance.
     * 
     * @var array
     */
    protected static $_picturesModel;
    
    /**
     * CRUD modules config files path.
     * 
     * @var string
     */
    protected $_modulesPath = null;

    /**
     * @var array
     */
    protected $_modules = null;

    /**
     * Set Tulipa_Crud::$_modulesPath
     *
     * @param string $modulesPath
     * @return Tulipa_Crud
     */
    public function setModulesPath($modulesPath = null)
    {
        $this->_modulesPath = (null === $modulesPath) ? null : (string) $modulesPath;
        return $this;
    }

    /**
     * Get Tulipa_Crud::$_modulesPath
     *
     * @return string
     */
    public function getModulesPath()
    {
        return $this->_modulesPath;
    }

    /**
     * Set Tulipa_Crud::$_modules
     *
     * @param array $modules
     * @return Tulipa_Crud
     */
    public function setModules($modules = null)
    {
        $this->_modules = (null === $modules) ? null : (array) $modules;
        return $this;
    }

    /**
     * Get Tulipa_Crud::$_modules
     *
     * @return array
     */
    public function getModules()
    {
        return $this->_modules;
    }

    /**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone()
    {}

    /**
     * Returns an instance of Tulipa_Crud
     *
     * Singleton pattern implementation
     *
     * @param array|Zend_Config $options
     * @return Tulipa_Crud Provides a fluent interface
     */
    public static function getInstance($options = null)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($options);
        }

        return self::$_instance;
    }
    
    /**
     * Initilize CRUD modules system.
     * 
     * @param array|Zend_Config $options
     * @return void
     * @throws Zend_Exception when $options is null
     * @throws Zend_Exception when $options is not array ot Zend_Config instance
     */
    protected function __construct($options)
    {
        if (is_null($options)) {
            throw new Zend_Exception('You must set CRUD modules options');
        }
        
        if (!is_array($options)) {
            if ($options instanceof Zend_Config) {
                $options = $options->toArray();
            } else {
                throw new Zend_Exception('$options must be array or Zend_Config object');
            }
        }
        
        $this->setOptions($options);
    }
    
    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Tulipa_Crud
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
     * Load CRUD modules.
     * 
     * @return void
     */
    public function init()
    {
        $cache = Zend_Registry::get('CACHE_MANAGER')->getCache('commonCache');
        $cacheId = self::CACHE_ID;
        
        if (!($crudModules = $cache->load($cacheId))) {
            $crudModules = $this->_getCrudModules();
            $cache->save($crudModules, $cacheId, array($cacheId));
        }
        
        $this->setModules($crudModules);
    	
    	Zend_Registry::set(self::ZEND_REGISTRY_INDEX, $crudModules);
    }
    
    /**
     * Load all available CRUD modules.
     * 
     * @return array
     * @throws Zend_Exception If CRUD directory doesn't exist
     */
    protected function _getCrudModules()
    {
    	/** Get the full CRUD modules directory path **/
	    $crudPath = realpath($this->getModulesPath());
        if (!isset($crudPath)) {
    		throw new Zend_Exception('CRUD modules path doesn\'t exist!');
    	}

    	/** Available CRUD modules storage **/
    	$crudModules = array();
    	
    	/** Using DirectoryIterator to iterate the CRUD directory **/
    	$crudDirectory = new DirectoryIterator($crudPath);
    	
    	foreach ($crudDirectory as $fileInfo)
    	{
    		if ($fileInfo->isFile()) {
    		    $filePathInfo = pathinfo($fileInfo->getFilename());
    		    if ($filePathInfo['extension'] == 'ini') {
        			$moduleConfig = new Zend_Config_Ini($crudPath . '/' 
        														  . $fileInfo->getFilename(),
										                APPLICATION_ENV);
				    $moduleName = basename($fileInfo->getFilename(), '.ini');
        											    
    			    /** Check is this module enabled **/
    			    if (isset($moduleConfig) && $moduleConfig->enabled) {
    			        $crudModules[$moduleName] = $moduleConfig;
    			    }
    		    }   			
    		}
    	}
    	
    	return $crudModules;
    }
    
    /**
     * Get Tulipa_Model_Crud_Files instance, 
     * configured for the given module.
     * 
     * @param string $moduleName
     * @param array $options
     * @return Tulipa_Model_Crud_Files
     */
    public static function getPicturesModel($moduleName, $options = array())
    {
        if (null === $moduleName) {
            throw new Zend_Exception('CRUD module name can\'t be null');
        }
        
        if (!is_string($moduleName)) {
            throw new Zend_Exception('CRUD module name must be string');
        }
        
        $loadedCrudModules = self::getInstance()->getModules();
        
        if (!isset($loadedCrudModules[$moduleName])) {
            throw new Zend_Exception('The requested CRUD module was not found 
            							or it\'s not enabled');
        }
        
        if (!isset($loadedCrudModules[$moduleName]->pictures)) {
            throw new Zend_Exception('This CRUD module does not support pictures.');
        }
        
        if (isset($options)) {
            if (!is_array($options) && $options instanceof Zend_Config) {
                $options = $options->toArray();
            }
            
            if (!is_array($options)) {
                throw new Zend_Exception('$options must be array or a Zend_Config object');
            }                
        }

        if (isset(self::$_picturesModel[$moduleName])) {
            return self::$_picturesModel[$moduleName]->setOptions($options);
        }
        
        // get pictures config
        $config = $loadedCrudModules[$moduleName]->pictures;
        
        $model = new Tulipa_Model_Crud_Files($config->toArray());
        $model->setOptions($options);
        
        if (isset($config->thumb->folder)) {
            $model->setThumbsFolder($config->thumb->folder);
        }
        
        self::$_picturesModel[$moduleName] = $model;
        
        return $model;
        
    }
    
    /**
     * Get Tulipa_Model_Crud_Files instance, 
     * configured for the given module.
     * 
     * @param string $moduleName
     * @param array $options
     * @return Tulipa_Model_Crud_Files
     */
    public static function getFilesModel($moduleName, $options = array())
    {
        if (null === $moduleName) {
            throw new Zend_Exception('CRUD module name can\'t be null');
        }
        
        if (!is_string($moduleName)) {
            throw new Zend_Exception('CRUD module name must be string');
        }
        
        $loadedCrudModules = self::getInstance()->getModules();
        
        if (!isset($loadedCrudModules[$moduleName])) {
            throw new Zend_Exception('The requested CRUD module was not found 
            							or it\'s not enabled');
        }
        
        if (!isset($loadedCrudModules[$moduleName]->files)) {
            throw new Zend_Exception('This CRUD module does not support pictures.');
        }
        
        if (isset($options)) {
            if (!is_array($options) && $options instanceof Zend_Config) {
                $options = $options->toArray();
            }
            
            if (!is_array($options)) {
                throw new Zend_Exception('$options must be array or a Zend_Config object');
            }                
        }

        if (isset(self::$_filesModel[$moduleName])) {
            return self::$_filesModel[$moduleName]->setOptions($options);
        }
        
        // get pictures config
        $config = $loadedCrudModules[$moduleName]->files;
                
        $model = new Tulipa_Model_Crud_Files($config->toArray());
        $model->setOptions($options);
        
        self::$_filesModel[$moduleName] = $model;
        
        return $model;
        
    }
    
    /**
     * Get model object for the requested CRUD module.
     * 
     * @param	string 				$moduleName 		
     * @param 	boolean				$includeLangModel 	If true and module is multilingual
     * 													will try to instantiate the proper
 	 * 													language model.	
     * @param  	array|Zend_Config 	$options
     * @return 	Tulipa_Model_Crud
     * @throws 	Zend_Exception 		If the requested module was not found 
     * 								or it's not enabled
     */
    public static function getModel($moduleName, $includeLangModel = false, $options = array())
    {
        $includeLangModel = isset($includeLangModel) ? $includeLangModel : false;
            
        if (null === $moduleName) {
            throw new Zend_Exception('CRUD module name can\'t be null');
        }
        
        if (!is_string($moduleName)) {
            throw new Zend_Exception('CRUD module name must be string');
        }
        
        $loadedCrudModules = self::getInstance()->getModules();
        
        if (!isset($loadedCrudModules[$moduleName])) {
            throw new Zend_Exception('The requested CRUD module was not found 
            							or it\'s not enabled');
        }
        
        if (isset($options)) {
            if (!is_array($options) && $options instanceof Zend_Config) {
                $options = $options->toArray();
            }
            
            if (!is_array($options)) {
                throw new Zend_Exception('$options must be array or a Zend_Config object');
            }                
        }
        
        $crudConfig = $loadedCrudModules[$moduleName];
        
        if (!isset(self::$_modulesModels[$moduleName])) {
            
            $model = new Tulipa_Model_Crud($options);
            $model->setCrudConfig($crudConfig);
            
            if (isset($crudConfig->extraModel)) {
                $extraModel = new $crudConfig->extraModel;                
                if (!($extraModel instanceof Tulipa_Model_Crud_Extra_Interface)) {
                    throw new Zend_Exception('Extra model must implement Tulipa_Model_Crud_Extra_Interface');
                }
                $extraModel->setModel($model);
                $model->setExtraModel($extraModel);
            }
            
            if (isset($crudConfig->db->table)) {
                $model->setTable($crudConfig->db->table);
            } else {
                throw new Zend_Exception('DB Table name must be set in the module\'s config file');
            }
            
            // Set alternative primary key column name
            if (isset($crudConfig->db->primaryKeyColumn)) {
                $model->setPrimaryKeyColumn($crudConfig->db->primaryKeyColumn);
            }
                        
            
            /** Include the language model for this module **/
            if ($includeLangModel) {
                if (!$crudConfig->lang->enabled) {
                    throw new Zend_Exception('This CRUD module doesn\'t support multilingual interface');
                } else {
                    $langConfig = $crudConfig->lang;
                    $langModel = new Tulipa_Model_Crud_Lang;
                    
                    if (isset($langConfig->table)) {
                        $langModel->setTable($langConfig->table);
                    } else {
                        throw new Zend_Exception('DB Table name(for translations) must be set in the module\'s config file');
                    }
                    
                    if (isset($options['_lang'])) {
                        $langModel->setOptions($options['_lang']);
                    }
                    
                    if (isset($langConfig->langColumn)) {
                        $langModel->setLangColumn($langConfig->langColumn);
                    }
                    
                    if (isset($langConfig->parentColumn)) {
                        $langModel->setParentColumn($langConfig->parentColumn);
                    }
                    
                    if (isset($langConfig->primaryKeyColumn)) {
                        $langModel->setPrimaryKeyColumn($langConfig->primaryKeyColumn);
                    }
                    
                    $model->setLangModel($langModel);
                }
            }
            
            self::$_modulesModels[$moduleName] = $model;
            
        } else {
            $langModel = self::$_modulesModels[$moduleName]->getLangModel();
            if ($includeLangModel && empty($langModel)) {
                if (!$crudConfig->lang->enabled) {
                    throw new Zend_Exception('This CRUD module doesn\'t support multilingual interface');
                } else {
                    $langConfig = $crudConfig->lang;
                    $langModel = new Tulipa_Model_Crud_Lang;
                    
                    if (isset($langConfig->table)) {
                        $langModel->setTable($langConfig->table);
                    } else {
                        throw new Zend_Exception('DB Table name(for translations) must be set in the module\'s config file');
                    }
                    
                    if (isset($options['_lang'])) {
                        $langModel->setOptions($options['_lang']);
                    }
                    
                    if (isset($langConfig->langColumn)) {
                        $langModel->setLangColumn($langConfig->langColumn);
                    }
                    
                    if (isset($langConfig->parentColumn)) {
                        $langModel->setParentColumn($langConfig->parentColumn);
                    }
                    
                    if (isset($langConfig->primaryKeyColumn)) {
                        $langModel->setPrimaryKeyColumn($langConfig->primaryKeyColumn);
                    }
                    
                    self::$_modulesModels[$moduleName]->setLangModel($langModel);
                }
            }
        }
                
        return self::$_modulesModels[$moduleName];
    }
}