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
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Search.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */
 
/**
 * Users search model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Users_Search extends Application_Model_Users
{
    const AGE_INTERVAL_TEEN = 'teen';
    const AGE_INTERVAL_YOUNG = 'young';
    const AGE_INTERVAL_AVERAGE = 'average';
    const AGE_INTERVAL_OLD = 'old';
    const AGE_INTERVAL_ALL = '';
    
    /**
     * @var string
     */
    protected $_dataMapperClassName = 'Application_Model_Mapper_Users';
    
    /**
     * @var boolean
     */
    protected $_showWithAvatarsOnly = false;
    
    /**
     * @var boolean
     */
    protected $_showOnlineOnly = false;
    
    /**
     * @var array
     */
    protected $_ageIntervals = array(
        self::AGE_INTERVAL_ALL => '',
        self::AGE_INTERVAL_TEEN => '18 - 22',
        self::AGE_INTERVAL_YOUNG => '22 - 30',
        self::AGE_INTERVAL_AVERAGE => '30 - 40',
        self::AGE_INTERVAL_OLD => '40 and more'
    );
    
    /**
     * @var array
     */
    protected $_ageIntervalsExpressions = array(
        self::AGE_INTERVAL_ALL => '',
        self::AGE_INTERVAL_TEEN => 'age >= 18 AND age <= 22',
        self::AGE_INTERVAL_YOUNG => 'age >= 22 AND age <= 30',
        self::AGE_INTERVAL_AVERAGE => 'age >= 30 AND age <= 40',
        self::AGE_INTERVAL_OLD => 'age >= 40'
    );
    
    /**
     * @var string
     */
    protected $_ageInterval = null;
    
    /**
     * Set Application_Model_Users_Search::$_showWithAvatarsOnly
     * 
     * @param boolean $showWithAvatarsOnly
     * @return Application_Model_Users_Search
     */
    public function setShowWithAvatarsOnly($showWithAvatarsOnly = false)
    {
        $this->_showWithAvatarsOnly = (boolean) $showWithAvatarsOnly;
        return $this;
    }

    /**
     * Get Application_Model_Users_Search::$_showWithAvatarsOnly
     * 
     * @return boolean
     */
    public function getShowWithAvatarsOnly()
    {
        return $this->_showWithAvatarsOnly;
    }

    /**
     * Set Application_Model_Users_Search::$_showOnlineOnly
     * 
     * @param boolean $showOnlineOnly
     * @return Application_Model_Users_Search
     */
    public function setShowOnlineOnly($showOnlineOnly = false)
    {
        $this->_showOnlineOnly = (boolean) $showOnlineOnly;
        return $this;
    }

    /**
     * Get Application_Model_Users_Search::$_showOnlineOnly
     * 
     * @return boolean
     */
    public function getShowOnlineOnly()
    {
        return $this->_showOnlineOnly;
    }

    /**
     * Set Application_Model_Users_Search::$_ageIntervals
     * 
     * @param array $ageIntervals
     * @return Application_Model_Users_Search
     */
    public function setAgeIntervals($ageIntervals = null)
    {
        $this->_ageIntervals = (array) $ageIntervals;
        return $this;
    }

    /**
     * Get Application_Model_Users_Search::$_ageIntervals
     * 
     * @return array
     */
    public function getAgeIntervals()
    {
        if (empty($this->_ageIntervals)) {
            return;
        }
        
        foreach ($this->_ageIntervals as $intervalKey => $intervalName)
        {
            $ageIntervals[$intervalKey] = $this->translate($intervalName);
        }
        
        return empty($ageIntervals) ? null : $ageIntervals;
    }

    /**
     * Set Application_Model_Users_Search::$_ageIntervalsExpressions
     * 
     * @param array $ageIntervalsExpressions
     * @return Application_Model_Users_Search
     */
    public function setAgeIntervalsExpressions($ageIntervalsExpressions = null)
    {
        $this->_ageIntervalsExpressions = (array) $ageIntervalsExpressions;
        return $this;
    }

    /**
     * Get Application_Model_Users_Search::$_ageIntervalsExpressions
     * 
     * @return array
     */
    public function getAgeIntervalsExpressions()
    {
        return $this->_ageIntervalsExpressions;
    }

    /**
     * Set Application_Model_Users_Search::$_ageInterval
     * 
     * @param string $ageInterval
     * @return Application_Model_Users_Search
     */
    public function setAgeInterval($ageInterval = null)
    {
        $this->_ageInterval = (string) $ageInterval;
        return $this;
    }

    /**
     * Get Application_Model_Users_Search::$_ageInterval
     * 
     * @return string
     */
    public function getAgeInterval()
    {
        return $this->_ageInterval;
    }

    /**
     * Get age interval expression.
     * 
     * @param string $key
     * @return string
     */
    public function getAgeIntervalExpression($key = null)
    {
        if (empty($key)) {
            return;
        }
        
        if (empty($this->_ageIntervalsExpressions[$key])) {
            return;
        }
        
        return $this->_ageIntervalsExpressions[$key];
    }
    
    /**
     * Search for users.
     * 
     * @param boolean $returnArray Return result in array
     * @return array|Zend_Db_Select|null
     */
    public function search($returnArray = false)
    {
        return $this->getMapper(self::DATA_MAPPER_VIEW_SUFFIX)
                    ->search($this, $returnArray);
    }
}