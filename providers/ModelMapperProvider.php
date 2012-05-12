<?php

require_once 'Zend/Tool/Project/Provider/Abstract.php';
require_once 'Zend/Tool/Project/Provider/Exception.php';

class ModelMapperProvider extends Zend_Tool_Project_Provider_Abstract
{
    
    const ABSTRACT_MODEL = 'Application_Model_DataEntityAbstract';
    const ABSTRACT_MAPPER = 'Application_Model_Mapper_DataEntityAbstract';
    
    /**
     * Model name.
     * @var string
     */
    protected $_name;
    
    /**
     * Module to use.
     * @var string
     */
    protected $_module = null;
    
    /**
     * Db Table name.
     * @var string
     */
    protected $_dbTableName = null;
    
    protected function _getFileDocblock($isMapper = false)
    {
        if (is_null($this->_module)) {
            $module = 'Application';
        } else {
            $module = $this->_module;
        }
        
        $name = ucfirst($this->_name);
        
        $category = ucfirst($module);
        $package = $isMapper ? $category . ' Mapper Models' : $category . ' Models';
        $subpackage = $name;
        $year = date('Y');
        
        return array(
            'shortDescription' => "phpAbility © \n"
            					  . "Copyright © $year Sasquatch <Joan-Alexander Grigorov>\n"
            					  . "                     http://bgscripts.com\n\n"
            				 . "LICENSE\n\n" 
		    				 . "A copy of this license is bundled with this package in the file LICENSE.txt.\n\n"
		    				 . "Copyright © phpAbility\n\n"
		    				 . "Platform that uses this site is protected by copyright.\n"
		    				 . "It is provided solely for the use of this site and all its copying,\n"
		    				 . "processing or use of parts thereof is prohibited and pursued by law.\n\n"
		    				 . "All rights reserved. Contact: office@bgscripts.com",
			'tags' => array(
            	array(
            	    'name' => 'category',
            	    'description' => "\t" . $category
            	),
            	array(
            	    'name' => 'package',
            	    'description' => "\t" . $package
            	),
            	array(
            	    'name' => 'subpackage',
            	    'description' => "\t" . $subpackage
            	),
            	array(
            	    'name' => 'copyright',
            	    'description' => "\tCopyright (c) $year Sasquatch MC"
            	),
            	array(
            	    'name' => 'version',
            	    'description' => "\t" . '$Id$'
            	)
			    
			)
        );
        
    }
    
    protected function _getTableColumns()
    {
        $this->_loadProfile(self::NO_PROFILE_THROW_EXCEPTION);
        
        $bootstrapResource = $this->_loadedProfile->search('BootstrapFile');
        
        /* @var $zendApp Zend_Application */
        $zendApp = $bootstrapResource->getApplicationInstance();
        
        try {
            $zendApp->bootstrap('db');
        } catch (Zend_Application_Exception $e) {
            return null;
        }
        
        /* @var $db Zend_Db_Adapter_Abstract */
        $db = $zendApp->getBootstrap()->getResource('db');
        
        $dbTableQuoted = $db->quoteIdentifier($this->_dbTableName);
                
        $columns = $db->fetchAll('DESCRIBE ' . $dbTableQuoted, null, Zend_Db::FETCH_CLASS);
                
        $dataFields = array();
        
        foreach ($columns as $column)
        {
            $dataFields[$column->Field] = null;
        }
        
        return $dataFields;
    }
    
    protected function _getModelContent($model = null, $mapper = null)
    {
        
        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($model)
              ->setProperties(array(
                  array(
                  	'name'         => '_mapperName',
                    'visibility'   => 'protected',
                    'defaultValue' => $mapper,
                  )
              ))
              ->setExtendedClass(self::ABSTRACT_MODEL);
        
        $dataFields = $this->_getTableColumns();
        
        if (!empty($dataFields)) {
            $class->setProperty(array(
                'name' => '_data',
                'visibility' => 'protected',
                'defaultValue' => $dataFields
            ));
        }
                
        $docblock = $this->_getFileDocblock();
        $file = new Zend_CodeGenerator_Php_File(array(
            'classes' => array($class),
            'docblock' => new Zend_CodeGenerator_Php_Docblock($docblock),
        ));
        
        array_pop($docblock['tags']);
        $docblock['shortDescription'] = ucfirst($this->_name) . ' model';
        
        $docblock['tags'][] = array(
     	    'name' => 'method',
    	    'description' => "\t\t" . $mapper . ' _getMapper()'
    	);
        
        $class->setDocblock(new Zend_CodeGenerator_Php_Docblock($docblock));
        
        return (string) $file;
    }
    
    protected function _getMapperContent($mapper = null, $dbTableName = null)
    {
        
        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($mapper)
              ->setProperties(array(
                  array(
                  	'name'         => '_tableName',
                    'visibility'   => 'protected',
                    'defaultValue' => $dbTableName,
                  )
              ))
              ->setExtendedClass(self::ABSTRACT_MAPPER);
      
        $docblock = $this->_getFileDocblock(true);
        $file = new Zend_CodeGenerator_Php_File(array(
            'classes' => array($class),
            'docblock' => new Zend_CodeGenerator_Php_Docblock($docblock),
        ));
        
        array_pop($docblock['tags']);
        $docblock['shortDescription'] = ucfirst($this->_name) . ' mapper model';
        $class->setDocblock(new Zend_CodeGenerator_Php_Docblock($docblock));
        
        return (string) $file;
    }
    
    public function create($name = null, $dbTableName = null, $module = null)
    {
        
        $appPath = realpath('application');
        
        if (is_null($name) || is_null($dbTableName)) {
            echo 'You must set name and DB Table name';
            return;
        }
        
        $this->_name = $name;
        $this->_dbTableName = $dbTableName;
        $this->_module = $module;
        
        if (is_null($module)) {
            $modelClass = 'Application_Model_' . ucfirst($name);
            $mapperClass = 'Application_Model_Mapper_' . ucfirst($name);
            $modelsPath = $appPath . '/models';
        } else {
            $modelClass = ucfirst($module) . '_Model_' . ucfirst($name);
            $mapperClass = ucfirst($module) . '_Model_Mapper_' . ucfirst($name);    
            $modelsPath = $appPath . '/modules/' . $module . '/models';        
        }
        
        $modelFile = $modelsPath . '/' . ucfirst($name) . '.php';
        $mapperFile = $modelsPath . '/mappers/' . ucfirst($name) . '.php';
                
        echo 'Created ' . $modelFile . "\n";
        echo 'Created ' . $mapperFile . "\n";
        
        file_put_contents($modelFile, $this->_getModelContent($modelClass, $mapperClass));
        file_put_contents($mapperFile, $this->_getMapperContent($mapperClass, $dbTableName));
    }
    
    


}

