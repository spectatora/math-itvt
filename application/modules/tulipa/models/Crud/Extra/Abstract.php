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
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Abstract.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD additional model abstract class.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
abstract class Tulipa_Model_Crud_Extra_Abstract implements Tulipa_Model_Crud_Extra_Interface
{
    /**
     * CRUD model instance.
     * 
     * @var Tulipa_Model_Crud
     */
    protected $_model = null;
    
    /**
     * Set CRUD model instance.
     * @see Tulipa_Model_Crud_Extra_Interface::setModel()
     */
    public function setModel(Tulipa_Model_Crud $model = null)
    {
        $this->_model = $model;
    }
    
    /**
     * @see Tulipa_Model_Crud_Extra_Interface::getModel()
     * @return Tulipa_Model_Crud
     */
    public function getModel()
    {
        return $this->_model;
    }
    
    /**
     * Set CRUD model instance.
     * 
     * @param Tulipa_Model_Crud $model
     */
    public function __construct(Tulipa_Model_Crud $model = null)
    {
        $this->setModel($model);
    }
    
    public function onBeforeBrowse($returnArray = false)
    {
    }

    public function onAfterBrowse($returnArray = false)
    {
    }
    
    public function onBeforeRead()
    {
    }
    
    public function onAfterRead(&$row)
    {
    }
    
    public function onBeforeUpdate()
    {
    }
    
    public function onAfterUpdate()
    {
    }
    
    public function onBeforeInsert()
    {
    }
    
    public function onAfterInsert($id)
    {
    }
    
    public function onBeforeDelete()
    {
    }
    
    public function onAfterDelete()
    {
    }
}

