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
 * @version    $Id: Friends.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for friends system.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Friends extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'friends';
    
    /**
     * Insert new friendship request/approval to the DB Table.
     * 
     * @param Application_Model_Abstract $model
     * @return int
     */
    public function insert(Application_Model_Abstract $model)
    {
        $data = $model->toArray();
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Get $_userId - $_friendId AND $_friendId - $_userId rows.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function getTwoWayRows(Application_Model_Abstract $model)
    {
        $select = $this->getDbTable()
                       ->select()
                       ->where('(`userId` = ?', $model->getUserId(), 'INTEGER')
                       ->where('`friendId` = ?)', $model->getFriendId(), 'INTEGER')
                       ->orWhere('(`friendId` = ?', $model->getUserId(), 'INTEGER')
                       ->where('`userId` = ?)', $model->getFriendId(), 'INTEGER');
        $resultSet = $this->getDbTable()->fetchAll($select);
        
        return empty($resultSet) ? null : $resultSet->toArray();        
    }
    
    /**
     * Delete all rows by given fields.
     * 
     * @param Application_Model_Abstract $model
     * @return array|null
     */
    public function delete(Application_Model_Abstract $model)
    {
        $adapter = $this->getAdapter();
        
        $userIdQuoted = $adapter->quote($model->getUserId(), 'INTEGER');
        $friendIdQuoted = $adapter->quote($model->getFriendId(), 'INTEGER');
        
        $where[] = '((`userId` = ' 
                    . $userIdQuoted
                    . ' AND `friendId` = ' 
                    . $friendIdQuoted
                    . ') OR (`userId` = ' 
                    . $friendIdQuoted
                    . ' AND `friendId` = ' 
                    . $userIdQuoted
                    . '))';
        
        return $this->getDbTable()->delete($where);
    }
}