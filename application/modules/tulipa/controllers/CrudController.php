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
 * @subpackage Pages
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: CrudController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD modules controller.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Tulipa_CrudController extends Tulipa_Controller_Action
{
        
    /**
     * @var Zend_Config
     */
    protected $_crudConfig = null;  
    
    /**
     * @var string
     */
    protected $_crudModuleName = null;
    
    /**
     * @var Zend_Translate
     */
    protected $_translator = null;

    /**
     * Clean menu cache.
     * 
     * @return void
     */
    protected function _cleanCache()
    {
        $cacheManager = Zend_Registry::get('CACHE_MANAGER');
        $cache = $cacheManager->getCache('unserializedCache');
        $cache->clean();
        // clear page cache
        Zend_Registry::get('PAGE_CACHE')->clean();
    }
    
    /**
     * Init the selected module.
     * @see Application_Controller_Action::init()
     * @throws Zend_Exception When the requested CRUD 
     * 						  module was not found
     */
    public function init()
    {
        $availableCrudModules = Zend_Registry::get(Tulipa_Crud::ZEND_REGISTRY_INDEX);
        $requestedCrudModule = $this->_getParam('crudModuleName');
        if (!isset($availableCrudModules[$requestedCrudModule])) {
            throw new Zend_Exception('The requested CRUD module was not found');
        }
        
        /** 
         * If the requested module is available,
         * assign it to the controller.
         */
        $this->_crudConfig = $availableCrudModules[$requestedCrudModule];
        $this->_crudModuleName = $requestedCrudModule;
        
        $this->_initTranslator();
        
        $langName = Application_Model_Language::getSessionLang()->name;
        
        $barTitle = $this->_crudConfig->name->default;
        
        if (isset($this->_crudConfig->name->$langName)) {
            $barTitle = $this->_crudConfig->name->$langName;
        }
        
        $this->view->alternativeTitle = $barTitle;
        $this->view->crudModuleName = $this->_crudModuleName;
        $this->view->crudConfig = $this->_crudConfig;
        $this->view->descriptions = $this->_crudConfig->descriptions;
    }
    
    /**
     * Init module translator.
     * 
     * @return void
     */
    protected function _initTranslator()
    {
        $translateFolder = realpath(
            dirname(__FILE__) . '/../' 
            . Tulipa_Bootstrap::CRUD_MODULES_TRANSLATE_FOLDER
        );
        
        $translateFile = $translateFolder . '/' . $this->_crudModuleName . '.php';
        
        $translateArray = array();
        if (file_exists($translateFile)) {
            $translateArray = include($translateFile);
        }
        
        $langName = Application_Model_Language::getSessionLang()->name;
        
        $translator = Zend_Form::getDefaultTranslator();
        
        if (isset($translateArray[$langName])) {
            
            if (empty($translator)) {
                $translator = new Zend_Translate('array', $translateArray[$langName], new Zend_Locale($langName));
                Zend_Form::setDefaultTranslator($translator);
            } else {
                $translator->addTranslation($translateArray[$langName], new Zend_Locale($langName));
            }
        }
            
        $this->_translator = $translator;
        
        $this->view->crudTranslator = $this->_translator;
    }
    
    /**
     * Display CRUD module items list.
     * 
     * @return void
     */
    public function indexAction()
    {
        $isLangEnabled = isset($this->_crudConfig->lang->enabled) ?
                         $this->_crudConfig->lang->enabled : false;
        
        $crudModel = Tulipa_Crud::getModel($this->_crudModuleName, $isLangEnabled);
                
        if (isset($this->_crudConfig->browse->fields)) {
            $crudModel->setColumnsForSelect($this->_crudConfig->browse->fields->toArray());
        }
        
        if ($isLangEnabled) {              
            // lang config shortcut
            $langConfig = $this->_crudConfig->lang;            
            $langModel = $crudModel->getLangModel()
                                   ->setColumnsForSelect(array());                                  
            if (isset($langConfig->fields)) {
                $langModel->setColumnsForSelect($langConfig->fields->toArray());
            }
        }
        
        $browseFields = $this->_crudConfig->browse->fields->toArray();
        
        if (isset($this->_crudConfig->lang->fields)) {
            $browseFields = array_merge($browseFields, 
                                        $this->_crudConfig->lang->fields->toArray());
        }
        
        $items = $crudModel->browse();
        
        $paginatorParams = array();
        
        /** Browse filter **/
        if (isset($this->_crudConfig->filter)) {
            $filterForm = new Tulipa_Form_Crud_Filter($this->_crudConfig->filter);
            $this->view->filterForm = $filterForm;
            $filterConfig = $this->_crudConfig->filter->toArray();
            $filterElementsNames = array_keys($filterConfig['elements']);
            $filterParams = $this->_getParams($filterElementsNames, true);
            $paginatorParams = $filterParams;
            if (!empty($filterParams)) {
                $filterForm->populate($filterParams);
                foreach ($filterParams as $paramName => $paramValue) 
                {
                    if (!empty($paramValue)) {
                        if ($filterConfig['elements'][$paramName]['type'] == 'text') {
                            $items->having('`' . $paramName . '` LIKE ?', '%' . $paramValue . '%', 'STRING');
                        } else {
                            $items->where('`' . $paramName . '` = ?', $paramValue);
                        }
                    }
                }
            }
        }
        
        $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($items);
        Application_Model_Paginator::create($paginatorAdapter, $this->_getParam('page'), 'items', $paginatorParams);
        
        
        $this->view->browseFields = $browseFields;
        $this->view->buttons = $this->_crudConfig->browse->buttons;
        
    }    
    
    /**
     * Initilize form.
     * 
     * @param array $values If $values is set will fill the form fields.
     * @return Tulipa_Form_Crud
     */
    protected function _initForm($values = null)
    {
        $form = new Tulipa_Form_Crud($this->_crudConfig->form->default);
        if ($this->_crudConfig->lang->enabled && isset($this->_crudConfig->form->lang)) {
            $form->setLangElements($this->_crudConfig->form->lang);
        }
        $form->initElements();
        $this->view->form = $form;
        
        if (isset($this->_crudConfig->pictures)) {
            $picturesConfig = $this->_crudConfig->pictures;
            $options = array(
                'destination' => $picturesConfig->destination,
                'label' => $this->translate('Pictures'),
                'required' => isset($picturesConfig->required) ? 
                                $picturesConfig : false,
                'multiFile' => $picturesConfig->count,
                'filters' => array(),
                'validators' => array(
                                    array(
                                        'Count', false, array(
                                         'max' => isset($picturesConfig->count) ?
                                                    $picturesConfig->count : 2
                                        )
                                    )
                                )
            );
            
            if (isset($picturesConfig->extension)) {
                $options['validators'][] = array('extension', false, 
                                                    $picturesConfig->extension);
            }
            
            if (isset($picturesConfig->size)) {
                
                $sizeOptions = array();
                
                if (isset($picturesConfig->size->min)) {
                    $sizeOptions['min'] = $picturesConfig->size->min;
                }
                
                if (isset($picturesConfig->size->max)) {
                    $sizeOptions['max'] = $picturesConfig->size->max;
                }
                
                $options['validators'][] = array('File_Size', false, $sizeOptions);
            }            
            
            if (isset($picturesConfig->resize)) {
                $options['filters']['Image_Resize'] = $picturesConfig->resize->toArray();
            }            
            
            if (isset($picturesConfig->rename)) {
                $options['filters']['RenameSaveExtension'] = $picturesConfig->rename->toArray();
            }
            
            if (isset($picturesConfig->thumb)) {
                $options['filters']['Image_Thumb'] = $picturesConfig->thumb->toArray();
            }
                       
            $form->addElement('file', 'pictures', $options);
        }
        
        if (isset($this->_crudConfig->files)) {
            $filesConfig = $this->_crudConfig->files;
            $options = array(
                'destination' => $filesConfig->destination,
                'label' => $this->translate('Files'),
                'required' => isset($filesConfig->required) ? 
                                $filesConfig : false,
                'multiFile' => $filesConfig->count,
                'filters' => array(),
                'validators' => array(
                                    array(
                                        'Count', false, array(
                                         'max' => isset($filesConfig->count) ?
                                                    $filesConfig->count : 2
                                        )
                                    )
                                )
            );
            
            if (isset($filesConfig->extension)) {
                $options['validators'][] = array('extension', false, 
                                                    $filesConfig->extension);
            }
            
            if (isset($filesConfig->rename)) {
                $options['filters']['RenameSaveExtension'] = $filesConfig->rename->toArray();
            }
                       
            $form->addElement('file', 'files', $options);
        }
        
        /** Add the submit button **/
        $form->addElement('submit', 'submitForm', array(
        	'label' => $this->translate('Create')
        ));
        
        if (isset($values) && is_array($values)) {
            // ignore values fields
            if (isset($this->_crudConfig->ignoreOnUpdateForm)) {
                $ignore = $this->_crudConfig->ignoreOnUpdateForm->toArray();
                if (count($ignore)) {
                    foreach ($ignore as $field) {
                        if (isset($values[$field])) {
                            unset($values[$field]);
                        }
                    }
                }
            }
            $form->populate($values);
        }
        
        $form->setTranslator($this->_translator);
        
        return $form;
    }
    
    /**
     * Add form.
     * 
     * @return void
     */
    public function addAction()
    {
        $form = $this->_initForm();
        
        if (isset($this->_crudConfig->pictures)) {
            $form->removeElement('pictures');
        }
        
        if (isset($this->_crudConfig->files)) {
            $form->removeElement('files');
        }
        
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            if ($form->isValid($request->getPost())) {
                                
                $formValues = $form->getValues();
                if (isset($formValues['translations'])) {
                    $langData =  $formValues['translations'];
                    unset($formValues['translations']);
                }
                
                $crudModel = Tulipa_Crud::getModel($this->_crudModuleName, 
                                                   $this->_crudConfig->lang->enabled,
                                                   array('data' => $formValues));
                
                $parentId = $crudModel->insert();
                
                if (isset($langData) && $this->_crudConfig->lang->enabled) {
                    
                    $crudLangModel = $crudModel->getLangModel()
                                               ->setParentId($parentId);
                    
                    foreach ($langData as $langId => $fields) {
                        $crudLangModel->setLangId($langId)
                                      ->setData($fields)
                                      ->insert();
                    }
                    
                }
                
                $editUrl = $this->url(array(
                    'action' => 'edit',
                    'id' => $parentId
                ), 'crud', false);
                
                $addUrl = $this->url(array(
                    'action' => 'add',
                    'id' => $parentId
                ), 'crud', false);
                
                $this->status(
                        $this->translate('Successfully added entry! Click <a href="%s">here</a> to edit it.', $editUrl) . '<br />'
                    .   $this->translate('Or click <a href="%s">here</a> to add new one.', $addUrl) 
                );
                
                $this->view->form = null;              
                $this->view->descriptions = null;
                
                // clean cache
                $this->_cleanCache();
                
            }
        }
        
    }
    
    /**
     * Edit item form.
     * 
     * @return void
     */
    public function editAction()
    {
        $id = $this->_getParam('id');
        $request = $this->getRequest();
        
        $isLangEnabled = isset($this->_crudConfig->lang->enabled) ?
                         $this->_crudConfig->lang->enabled : false;
        
        $crudModel = Tulipa_Crud::getModel($this->_crudModuleName, 
                                           $isLangEnabled, 
                                           array('id' => $id));
                                           
        $row = $crudModel->read();
        
        if (empty($row)) {
            $this->status($this->translate('No entry found with this id'), 'error', true);
            $this->render('edit');
            return;
        }
        
        if ($isLangEnabled) {
            
            $crudLangModel = $crudModel->getLangModel()
                                       ->setParentId($id);
            
            $row['translations'] = $crudLangModel->browseForForm();
        }
        
        $form = $this->_initForm($row);
        $form->submitForm->setLabel($this->translate('Edit'));
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $formValues = $form->getValues();
                if (isset($formValues['translations'])) {
                    $langData =  $formValues['translations'];
                    unset($formValues['translations']);
                }
                
                if (isset($this->_crudConfig->pictures)) {
                    $pictures = $formValues['pictures'];
                    $picturesModel = Tulipa_Crud::getPicturesModel(
                        $this->_crudModuleName,
                        array(
                        	'files' => $pictures,
                        	'parentId' => $id
                        )
                    );
                    $picturesModel->insert();
                    unset($formValues['pictures']);
                }
                
                if (isset($this->_crudConfig->files)) {
                    $files = $formValues['files'];
                    $filesModel = Tulipa_Crud::getFilesModel(
                        $this->_crudModuleName,
                        array(
                        	'files' => $files,
                        	'parentId' => $id
                        )
                    );
                    $filesModel->insert();
                    unset($formValues['files']);
                }
                
                /** If the default fields are empty, no update is needed **/
                if (!empty($formValues)) {
                    
                    foreach ($formValues as $sField => $sValue) {
                        if (!isset($sValue)) {
                            unset($formValues[$sField]);
                        }
                    }
                    
                    if (isset($this->_crudConfig->ignoreOnUpdateForm)) {
                        $ignore = $this->_crudConfig->ignoreOnUpdateForm->toArray();
                        if (count($ignore)) {
                            foreach ($ignore as $field) {
                                $value = $request->getPost($field);
                                if (empty($value)) {
                                    unset($formValues[$field]);
                                }
                            }
                        }
                    }
                    
                    $crudModel->setData($formValues)->update();
                }
                
                if (isset($langData)) {
                    foreach ($langData as $langId => $fields) {
                        $crudLangModel->setLangId($langId)
                                      ->setData($fields)
                                      ->update();
                    }
                }
                
                $this->status($this->translate('Successfully edited entry!'));                
                $this->view->descriptions = null;
                
                // clean cache
                $this->_cleanCache();
            }
        }
        
        /** Get pictures **/
        if (isset($this->_crudConfig->pictures)) {
            $picturesModel = Tulipa_Crud::getPicturesModel($this->_crudModuleName, array(
                'parentId' => $id
            ));
            $this->view->picturesModel = $picturesModel;
            $this->view->pictures = $picturesModel->browse(true);
        }
    }
    
    public function filesAction()
    {
        $id = $this->_getParam('id');
        /** Get files **/
        if (isset($this->_crudConfig->files)) {
            $filesModel = Tulipa_Crud::getFilesModel($this->_crudModuleName, array(
                'parentId' => $id
            ));
            $this->view->filesModel = $filesModel;            
            $items = $filesModel->browse(false);
            
            $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($items);
            Application_Model_Paginator::create($paginatorAdapter, $this->_getParam('page'), 'items');
            
        }
    }
    
    /**
     * Delete item.
     * 
     * @return void
     */
    public function deleteAction()
    {
        
        $id = $this->_getParam('id');
        $request = $this->getRequest();
                
        $isLangEnabled = isset($this->_crudConfig->lang->enabled) ?
                         $this->_crudConfig->lang->enabled : false;
        
        $crudModel = Tulipa_Crud::getModel($this->_crudModuleName, 
                                           $isLangEnabled, 
                                           array(
                                               'id' => $id
                                           ));
        
        $row = $crudModel->read();
        
        if (empty($row)) {
            $this->status($this->translate('No entry found with this id'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $crudModel->delete();        
        
        $this->status($this->translate('Item successfully deleted'));
        $this->outputStatusJson();
                
        // clean cache
        $this->_cleanCache();
    }
    
    /**
     * Delete picture.
     * 
     * @return void
     */
    public function deletePictureAction()
    {
        
        $id = $this->_getParam('id');
        $request = $this->getRequest();
        
        if (!isset($this->_crudConfig->pictures)) {
            $this->status($this->translate('Pictures are not available in this module'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $picturesModel = Tulipa_Crud::getPicturesModel($this->_crudModuleName, array(
            'id' => $id 
        ));
        
        $picture = $picturesModel->read();
        
        if (empty($picture)) {
            $this->status($this->translate('No entry found with this id'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $filenameColumn = $picturesModel->getFilenameColumn();
                
        $filePath = $picturesModel->destination . '/' . $picture[$filenameColumn];
        $thumbPath = $picturesModel->destination . '/' 
                     . $picturesModel->thumbsFolder . '/' 
                     . $picture[$filenameColumn];
        
        if (file_exists($filePath)) {
            unlink($filePath);
        } 
        
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
                     
        $picturesModel->delete();        
        
        $this->status($this->translate('Picture successfully deleted'));
        $this->outputStatusJson();
                
        // clean cache
        $this->_cleanCache();
    }
    
    /**
     * Delete picture.
     * 
     * @return void
     */
    public function deleteFileAction()
    {
        
        $id = $this->_getParam('id');
        $request = $this->getRequest();
        
        if (!isset($this->_crudConfig->files)) {
            $this->status($this->translate('Files are not available in this module'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $filesModel = Tulipa_Crud::getFilesModel($this->_crudModuleName, array(
            'id' => $id 
        ));
        
        $file = $filesModel->read();
        
        if (empty($file)) {
            $this->status($this->translate('No entry found with this id'), 'error', true);
            $this->outputStatusJson();
            return;
        }
        
        $filenameColumn = $filesModel->getFilenameColumn();
                
        $filePath = $filesModel->destination . '/' . $file[$filenameColumn];
        $thumbPath = $filesModel->destination . '/' 
                     . $filesModel->thumbsFolder . '/' 
                     . $file[$filenameColumn];
        
        if (file_exists($filePath)) {
            unlink($filePath);
        } 
        
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
                     
        $filesModel->delete();        
        
        $this->status($this->translate('File successfully deleted'));
        $this->outputStatusJson();
                
        // clean cache
        $this->_cleanCache();
    }
    
}