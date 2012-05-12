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
 * @package    Tulipa_Controllers
 * @subpackage Generator
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: GeneratorController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * `Setter` and `getter` methods generator controller.
 * 
 * @author     Joan Grigorov a.k.a Sasquatch (office@bgscripts.com)
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage Generator
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_GeneratorController extends Tulipa_Controller_Action
{
    /**
     * Generates setter and getter methods.
     * 
     * @return
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        
        $form = new Tulipa_Form_Generator;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            
            if ($form->isValid($request->getPost())) {
                /**
                 * Create the class.
                 */
                $className = $form->getValue('className');
                
                $class = new Zend_CodeGenerator_Php_Class();
                
                $class->setName($className);
                /**
                 * Seperate attributes.
                 */
                $attributes = explode(',', $form->getValue('attributes'));
                
                foreach ($attributes as $attribute) {
                    $attribute = trim($attribute);
                    if (!empty($attribute)) {
                        
                        $regexp = '@^(.+)\((string|int|float|double|array|boolean|bool|null|mixed|resource)+\)(\((.*)\))*$@';
                        
                        if (preg_match($regexp, $attribute, $matches)) {
                            $attributeName = $matches[1];
                            $attributeType = $matches[2];
                            $attributeDefaultValue = isset($matches[3]) ? $matches[4] : null;
                            if (!empty($attributeDefaultValue)) {
                                eval('$attributeDefaultValue = (' . $attributeType . ') $attributeDefaultValue;');
                            }
                        } else {
                            $attributeName = $attribute;
                            $attributeType = 'mixed';
                            $attributeDefaultValue = null;
                        }
                        
                        $class->setProperty(
                            array(
                                'name' => '_' . $attributeName,
                                'visibility' => $form->getValue('access'),
                                'defaultValue' => $attributeDefaultValue,
                                'docblock' => new Zend_CodeGenerator_Php_Docblock(array(
                                    'tags' => array(
                                        array(
                                            'name' => 'var',
                                            'description' => $attributeType
                                        )
                                    ),
                                )),
                            )
                        );
                        
                        $class->setMethods(
                            array(
                                array(
                                    'name' => 'set' . ucfirst($attributeName),
                                    'parameters' => array(
                                        array(
                                            'name' => $attributeName,
                                            'defaultValue' => $attributeDefaultValue
                                        )
                                    ),
                                    'body' => '$this->_' . $attributeName 
                                              . ' = (null === $' . $attributeName . ') ? null : '
                                              . '(' . $attributeType . ') $' . $attributeName 
                                              . ";\n"
                                			  . 'return $this;',
                                    'docblock'   => new Zend_CodeGenerator_Php_Docblock(array(
                                        'shortDescription' => 'Set ' . $className . '::$_' . $attributeName,
                                        'tags'             => array(
                                            new Zend_CodeGenerator_Php_Docblock_Tag_Param(array(
                                                'paramName' => $attributeName,
                                                'datatype'  => $attributeType
                                            )),
                                            new Zend_CodeGenerator_Php_Docblock_Tag_Return(array(
                                                'datatype'  => $className,
                                            )),
                                        ),
                                    )),
                                ),
                                array(
                                    'name' => 'get' . ucfirst($attributeName),
                                    'body' => 'return $this->_' . $attributeName . ';',
                                    'docblock'   => new Zend_CodeGenerator_Php_Docblock(array(
                                        'shortDescription' => 'Get ' . $className . '::$_' . $attributeName,
                                        'tags'             => array(
                                            new Zend_CodeGenerator_Php_Docblock_Tag_Return(array(
                                                'datatype'  => $attributeType,
                                            )),
                                        ),
                                    )),
                                )
                            )
                        );
                        
                        $classAsFile = new Zend_CodeGenerator_Php_File(array('classes' => array($class)));
                        
                        $this->view->code = $classAsFile->generate();
                        
                    }                    
                }
                
            }
            
        }
        
    }
}