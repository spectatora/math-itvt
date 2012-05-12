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
 * @version    $Id: Translations.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Data Mapper Model for Acl Role Translations.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Mapper
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Mapper_Acl_Adapter_Roles_Translations extends Application_Model_Mapper_Abstract
{
    /**
     * DB Table name suffix.
     * 
     * @var string
     */
    protected $_dbTableNameSuffix = 'acl_roles_translations';
    
    /**
     * Add new Acl Role Translation.
     * 
     * @param Application_Model_Acl_Adapter_Roles_Translations $model
     * @return int Primary key of the inserted row
     */
    public function insert(Application_Model_Acl_Adapter_Roles_Translations $model)
    {
        $data = array(
            'title' => $model->getTitle(),
            'roleId' => $model->getRoleId(),
            'langId' => $model->getLangId()
        );
        
        return $this->getDbTable()->insert($data);
    }
    
    /**
     * Update Acl Role Translation.
     * 
     * @param Application_Model_Acl_Adapter_Roles_Translations $model
     * @return int Primary key of the updated row(s)
     */
    public function update(Application_Model_Acl_Adapter_Roles_Translations $model)
    {
        $data = array(
            'title' => $model->getTitle()
        );
        
        $where = array(
            'roleId = ?' => $model->getRoleId(),
            'langId = ?' => $model->getLangId()
        );
        
        return $this->getDbTable()->update($data, $where);
    }
    
    /**
     * Get translations by Acl Role id.
     * 
     * @param Application_Model_Acl_Adapter_Roles_Translations $model
     * @return array|null
     */
    public function getByRoleId(Application_Model_Acl_Adapter_Roles_Translations $model)
    {
        $select = $this->getDbTable()->select()
                                     ->where('roleId = ?', $model->getRoleId(), 'INTEGER');
        
        $result = $this->getDbTable()->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
        
    }
    
    /**
     * Get translations by Acl Role id and language id.
     * 
     * @param Application_Model_Acl_Adapter_Roles_Translations $model
     * @return array|null
     */
    public function get(Application_Model_Acl_Adapter_Roles_Translations $model)
    {
        $select = $this->getDbTable()->select()
                                     ->where('roleId = ?', $model->getRoleId(), 'INTEGER')
                                     ->where('langId = ?', $model->getLangId(), 'INTEGER');
        
        $result = $this->getDbTable()->fetchRow($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
        
    }
}