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
 * @version    $Id: Interface.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * CRUD additional model interface.
 * 
 * @category   Tulipa
 * @package    Tulipa_Models
 * @subpackage CRUD
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
interface Tulipa_Model_Crud_Extra_Interface
{
    
    /**
     * Set CRUD model instance.
     * 
     * @param Tulipa_Model_Crud $model
     * @return Tulipa_Model_Crud_Extra_Interface
     */
    public function setModel(Tulipa_Model_Crud $model = null);
    
    /**
     * Get CRUD model instance.
     * 
     * @return Tulipa_Model_Crud
     */
    public function getModel();
    
    /**
	 * Executed before browse DB Table rows.
	 * 
	 * @param $returnArray
	 * @return void
	 */
    public function onBeforeBrowse($returnArray = false);
    
    /**
	 * Executed after browse DB Table rows.
	 * 
	 * @param $returnArray
	 * @return void
	 */
    public function onAfterBrowse($returnArray = false);
    
    /**
     * Execute before selecting single row.
     * 
     * @return void
     */
    public function onBeforeRead();
    
    /**
     * Execute after selecting single row.
     * 
     * @param array $row Row data
     * @return void
     */
    public function onAfterRead(&$row);
    
    /**
     * Execute before row update.
     * 
     * @return void
     */
    public function onBeforeUpdate();
    
    /**
     * Execute after row update.
     * 
     * @return void
     */
    public function onAfterUpdate();
    
    /**
     * Execute before creating new row.
     * 
     * @return void
     */
    public function onBeforeInsert();
    
    /**
     * Execute after creating new row.
     * 
     * @param int $id Inserted row primary key column value
     * @return void
     */
    public function onAfterInsert($id);
    
    /**
     * Execute before deleting row.
     * 
     * @return void
     */
    public function onBeforeDelete();
    
    /**
     * Execute after deleting row.
     * 
     * @return void
     */
    public function onAfterDelete();
}