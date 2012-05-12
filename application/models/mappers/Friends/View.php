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
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: View.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for friends DB View.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Friends_View extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'friends_view';
    
    /**
     * Read single row from the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function read(Application_Model_Abstract $model)
    {
        $select = $this->getDbTable()
                       ->select();
                       
        $this->_arrayToWhere($model->toArray(true, null, array('userId', 'friendId', 'id')), $select);        
        
        $resultSet = $this->getDbTable()->fetchRow($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }
    
    /**
     * Browse rows from the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @param array $allowed
     * @return array|null
     */
    public function browse(Application_Model_Abstract $model, $allowed = null)
    {
        $select = $this->getDbTable()
                       ->select();
                       
        $this->_arrayToWhere($model->toArray(true, null, $allowed), $select);        
        
        $resultSet = $this->getDbTable()->fetchAll($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();
    }
}