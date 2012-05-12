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
 * @package    Application_Bread
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Interface.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Interface for the BREAD (Browse-Read-Edit(Update)-Add(Insert)-Delete) structure.
 * 
 * All models that are using these basic operations MUST implement this interface.
 * 
 * @category   Application
 * @package    Application_Bread
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
interface Application_Bread_Interface
{
	/**
	 * Browse DB Table rows.
	 * 
	 * @param $returnArray If it's true - return result as array,
	 *                     if it's false - return Zend_Db_Select instance 
	 *                     (frequently used for Zend_Paginator).
	 * @return null|array|Zend_Db_Select
	 */
	public function browse($returnArray = false);
	
	/**
	 * Read single row from the DB Table.
	 * 
	 * Usually retrive information by the primary key column(id).
	 * 
	 * @return null|array
	 */
	public function read();
	
	/**
	 * Update row(s).
	 * 
	 * Usually update single row by the primary key column(id).
	 * 
     * @return Application_Bread_Interface
	 */
	public function update();
	
	/**
	 * Insert new row to the DB Table.
	 * 
	 * Extract information from model's setter/getter methods
	 * and insert it to the DB Table as a new row.
	 * 
	 * @return Application_Bread_Interface
	 */
	public function insert();
	
	/**
	 * Delete row(s).
	 * 
	 * Usually delete single row by the primary key column(id).
	 * 
	 * @return Application_Bread_Interface
	 */
	public function delete();
}