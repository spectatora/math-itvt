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
 * @package    Application_Zodiac
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: Zodiac.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Zodiac signs calculations.
 * 
 * @category   Application
 * @package    Application_Zodiac
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Zodiac
{
    const CAPRICORN = 'Capricorn';
    const AQUARIUS = 'Aquarius';
    const PISCES = 'Pisces';
    const ARIES = 'Aries';
    const TAURUS = 'Taurus';
    const GEMINI = 'Gemini';
    const CANCER = 'Cancer';
    const LEO = 'Leo';
    const VIRGO = 'Virgo';
    const LIBRA = 'Libra';
    const SCORPIO = 'Scorpio';
    const SAGITTARIUS = 'Sagittarius';
    
    /**
     * @var array
     */
    private $_signs = array(
        1 => self::CAPRICORN,
        2 => self::AQUARIUS,
        3 => self::PISCES,
        4 => self::ARIES,
        5 => self::TAURUS,
        6 => self::GEMINI,
        7 => self::CANCER,
        8 => self::LEO,
        9 => self::VIRGO,
        10 => self::LIBRA,
        11 => self::SCORPIO,
        12 => self::SAGITTARIUS
    );

    /**
     * @var array
     */
    private $_blocks = array(
        13 => 356,
        12 => 326,
        11 => 296,
        10 => 266,
        9 => 235,
        8 => 203,
        7 => 172,
        6 => 140,
        5 => 111,
        4 => 78,
        3 => 51,
        2 => 20,
        1 => 0
    );

    /**
     * Set Application_Model_Zodiac::$_signs
     * 
     * @param array $signs
     * @return Application_Model_Zodiac
     */
    public function setSigns($signs = null)
    {
        $this->_signs = (array) $signs;
        return $this;
    }

    /**
     * Get Application_Model_Zodiac::$_signs
     * 
     * @return array
     */
    public function getSigns()
    {
        return $this->_signs;
    }

    /**
     * Set Application_Model_Zodiac::$_blocks
     * 
     * @param array $blocks
     * @return Application_Model_Zodiac
     */
    public function setBlocks($blocks = null)
    {
        $this->_blocks = (array) $blocks;
        return $this;
    }

    /**
     * Get Application_Model_Zodiac::$_blocks
     * 
     * @return array
     */
    public function getBlocks()
    {
        return $this->_blocks;
    }

    /**
     * Get day number
     * 
     * @param int $month
     * @param int $day
     * @return int
     */
    private function _getDayNumber($month, $day)
    {
        $num = getdate(mktime(2, 0, 0, $month, $day));
        return $num['yday'];
    }
    
    /**
     * Get zodiacal sign by month and day.
     * 
     * @param int $month
     * @param int $day
     * @return string
     */
    public function getSign($month, $day)
    {
        $day_num = $this->_getDayNumber((int) $month, (int) $day);
        /** Loop through the day blocks **/
        foreach ($this->_blocks as $key => $value)
        {
            if ($day_num >= $value) {
                break;
            }
        }
        /** Don't forget capricorn **/
        $key = ( $key > 12 ) ? 1 : $key; 
        return $this->_signs[$key]; 
    }
}