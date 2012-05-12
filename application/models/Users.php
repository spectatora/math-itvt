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
 * @version    $Id: Users.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Users model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Users
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_Users extends Application_Model_Abstract
                              implements Application_Bread_Interface
{
    const DATA_MAPPER_VIEW_SUFFIX = 'Users_View';
    
    /** Genres **/
    const GENRE_MALE = 'male';
    const GENRE_FEMALE = 'female';
    const GENRE_UNDEFINED = null;
    
    /**
     * @var int
     */
    protected $_id = null;

    /**
     * @var string
     */
    protected $_username = null;

    /**
     * @var string
     */
    protected $_email = null;

    /**
     * @var string
     */
    protected $_password = null;

    /**
     * @var string
     */
    protected $_key = null;

    /**
     * @var int
     */
    protected $_active = 1;

    /**
     * @var int
     */
    protected $_banned = null;

    /**
     * @var int
     */
    protected $_roleId = 2;

    /**
     * @var string
     */
    protected $_genre = null;

    /**
     * @var int
     */
    protected $_countryId = null;

    /**
     * @var int
     */
    protected $_cityId = null;

    /**
     * @var string
     */
    protected $_dateOfBirth = null;

    /**
     * @var string
     */
    protected $_firstName = null;

    /**
     * @var string
     */
    protected $_lastName = null;
    
    /**
     * @var string
     */
    protected $_ipOfRegistration = null;
    
    /**
     * @var string
     */
    protected $_ipOfLastLogin = null;
    
    /**
     * @var string
     */
    protected $_avatar = null;
    
    /**
     * @var string|Zend_Db_Expr
     */
    protected $_lastCheck = null;
    
    /**
     * Keyword for searching the users database.
     * @var string
     */
    protected $_keyword = null;
    
    /**
     * @var array
     */
    protected $_genres = array(
        self::GENRE_UNDEFINED => null,
        self::GENRE_MALE => 'male',
        self::GENRE_FEMALE => 'female',
    );
    
    /**
     * Set Application_Model_Users::$_id
     * 
     * @param int $id
     * @return Application_Model_Users
     */
    public function setId($id = null)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Application_Model_Users::$_username
     * 
     * @param string $username
     * @return Application_Model_Users
     */
    public function setUsername($username = null)
    {
        $this->_username = (string) $username;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_username
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Set Application_Model_Users::$_email
     * 
     * @param string $email
     * @return Application_Model_Users
     */
    public function setEmail($email = null)
    {
        $this->_email = (string) $email;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_email
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Set Application_Model_Users::$_password
     * 
     * @param string $password
     * @return Application_Model_Users
     */
    public function setPassword($password = null)
    {
        $this->_password = (string) $password;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_password
     * 
     * @param boolean $hash Return md5 hashed value of the password
     * @return string
     */
    public function getPassword($hash = true)
    {
        if ($hash) {
            if (!empty($this->_password)) {
                return md5($this->_password);
            }
        }
        return $this->_password;
    }

    /**
     * Set Application_Model_Users::$_key
     * 
     * @param string $key
     * @return Application_Model_Users
     */
    public function setKey($key = null)
    {
        $this->_key = (string) $key;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_key
     * 
     * @return string
     */
    public function getKey()
    {
        if (empty($this->_key)) {
            $this->_key = md5(uniqid(null, true));
        }
        
        return $this->_key;
    }

    /**
     * Set Application_Model_Users::$_active
     * 
     * @param boolean|int $active
     * @return Application_Model_Users
     */
    public function setActive($active = null)
    {
        $this->_active = (int) $active;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_active
     * 
     * @return int
     */
    public function getActive()
    {
        return $this->_active;
    }

    /**
     * Set Application_Model_Users::$_banned
     * 
     * @param boolean|int $banned
     * @return Application_Model_Users
     */
    public function setBanned($banned = null)
    {
        $this->_banned = (int) $banned;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_banned
     * 
     * @return int
     */
    public function getBanned()
    {
        return $this->_banned;
    }

    /**
     * Set Application_Model_Users::$_roleId
     * 
     * @param int|null $roleId
     * @return Application_Model_Users
     */
    public function setRoleId($roleId = null)
    {
        $this->_roleId = !empty($roleId) ? (int) $roleId : null;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_roleId
     * 
     * @return int|null
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }

    /**
     * Set Application_Model_Users::$_genre
     * 
     * @param string $genre
     * @return Application_Model_Users
     */
    public function setGenre($genre = null)
    {
        if (in_array($genre, $this->_genres)) {
            $this->_genre = $genre;
        } else {
            $this->_genre = null;
        }
        return $this;
    }

    /**
     * Get Application_Model_Users::$_genre
     * 
     * @return string
     */
    public function getGenre()
    {
        return $this->_genre;
    }

    /**
     * Set Application_Model_Users::$_countryId
     * 
     * @param int|null $countryId
     * @return Application_Model_Users
     */
    public function setCountryId($countryId = null)
    {
        $this->_countryId = !empty($countryId) ? (int) $countryId : null;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_countryId
     * 
     * @return int|null
     */
    public function getCountryId()
    {
        return $this->_countryId;
    }

    /**
     * Set Application_Model_Users::$_cityId
     * 
     * @param int $cityId
     * @return Application_Model_Users
     */
    public function setCityId($cityId = null)
    {
        $this->_cityId = !empty($cityId) ? (int) $cityId : null;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_cityId
     * 
     * @return int
     */
    public function getCityId()
    {
        return $this->_cityId;
    }

    /**
     * Set Application_Model_Users::$_dateOfBirth
     * 
     * @param string $dateOfBirth
     * @return Application_Model_Users
     */
    public function setDateOfBirth($dateOfBirth = null)
    {
        $this->_dateOfBirth = (string) $dateOfBirth;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_dateOfBirth
     * 
     * @return string
     */
    public function getDateOfBirth()
    {
        if (isset($this->_dateOfBirth)) {
            if (!self::isDateValid($this->_dateOfBirth)) {
                $this->_dateOfBirth = null;
            }
        }
        
        return $this->_dateOfBirth;
    }

    /**
     * Set Application_Model_Users::$_firstName
     * 
     * @param string $firstName
     * @return Application_Model_Users
     */
    public function setFirstName($firstName = null)
    {
        $this->_firstName = (string) $firstName;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_firstName
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * Set Application_Model_Users::$_lastName
     * 
     * @param string $lastName
     * @return Application_Model_Users
     */
    public function setLastName($lastName = null)
    {
        $this->_lastName = (string) $lastName;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_lastName
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
    }
    
    /**
     * Set Application_Model_Users::$_ipOfRegistration
     * 
     * @param string $ipOfRegistration
     * @return Application_Model_Users
     */
    public function setIpOfRegistration($ipOfRegistration = null)
    {
        $this->_ipOfRegistration = (string) $ipOfRegistration;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_ipOfRegistration
     * 
     * @return string
     */
    public function getIpOfRegistration()
    {
        if (null === $this->_ipOfRegistration) {
            $this->_ipOfRegistration = $_SERVER["REMOTE_ADDR"];
        }
        
        return $this->_ipOfRegistration;
    }

    /**
     * Set Application_Model_Users::$_ipOfLastLogin
     * 
     * @param string $ipOfLastLogin
     * @return Application_Model_Users
     */
    public function setIpOfLastLogin($ipOfLastLogin = null)
    {
        if (null === $ipOfLastLogin) {
            $this->_ipOfLastLogin = null;
            return $this;
        }
        $this->_ipOfLastLogin = (string) $ipOfLastLogin;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_ipOfLastLogin
     * 
     * @return string
     */
    public function getIpOfLastLogin()
    {
        return $this->_ipOfLastLogin;
    }

    /**
     * Set Application_Model_Users::$_avatar
     * 
     * @param string $avatar
     * @return Application_Model_Users
     */
    public function setAvatar($avatar = null)
    {
        $this->_avatar = (string) $avatar;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_avatar
     * 
     * @return string
     */
    public function getAvatar()
    {
        return $this->_avatar;
    }
    
    /**
     * Set Application_Model_Users::$_lastCheck
     * 
     * @param string|Zend_Db_Expr $lastCheck
     * @return Application_Model_Users
     */
    public function setLastCheck($lastCheck = null)
    {
        $this->_lastCheck = empty($lastCheck) ? new Zend_Db_Expr('NOW()') : $lastCheck;
        
        return $this;
    }

    /**
     * Get Application_Model_Users::$_lastCheck
     * 
     * @return string|Zend_Db_Expr
     */
    public function getLastCheck()
    {
        if (empty($this->_lastCheck)) {
            $this->setLastCheck();
        }
        return $this->_lastCheck;
    }

    /**
     * Set Application_Model_Users::$_genres
     * 
     * @param array $genres
     * @return Application_Model_Users
     */
    public function setGenres($genres = null)
    {
        $this->_genres = (array) $genres;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_genres
     * 
     * @return array|null
     */
    public function getGenres()
    {
        if (empty($this->_genres)) {
            return;
        }
        
        foreach ($this->_genres as $genreKey => $genreName)
        {
            $genres[$genreKey] = $this->translate(array($genreName, $genreName, 1));
        }
        
        return empty($genres) ? null : $genres;
    }

    /**
     * Set Application_Model_Users::$_keyword
     * 
     * @param string $keyword
     * @return Application_Model_Users
     */
    public function setKeyword($keyword = null)
    {
        if (null === $keyword) {
            $this->_keyword = null;
            return $this;
        }
        $this->_keyword = (string) $keyword;
        return $this;
    }

    /**
     * Get Application_Model_Users::$_keyword
     * 
     * @return string
     */
    public function getKeyword()
    {
        return $this->_keyword;
    }
    
    /**
     * Browse all users.
     * 
     * @param boolean $returnArray
     * @return array|null
     */
    public function browse($returnArray = false)
    {
        return $this->getMapper(self::DATA_MAPPER_VIEW_SUFFIX)
                    ->browse($this, $returnArray);
    }
        
    /**
     * Browse users by given options.
     * 
     * This method is different from {@link browse()},
     * browseAdvanced() uses advanced options.
     * 
     * @param array|Zend_Db_Select|null $returnArray
     * @param array $allowed Fields to use for matching
     * @return array|null
     */
    public function browseAdvanced($returnArray = false, $allowed = null)
    {
        return $this->getMapper(self::DATA_MAPPER_VIEW_SUFFIX)
                    ->browseByRoleId($this, $returnArray, $allowed);
    }
    
    /**
     * Get user by id.
     * 
     * @return array|null
     */
    public function read()
    {
        $user = $this->getMapper(self::DATA_MAPPER_VIEW_SUFFIX)
                     ->read($this);
                     
        if (empty($user)) {
            $this->addError($this->translate('User not found'));
            return null;
        }
        
        $this->setOptions($user);
        
        /** 
         * The password, retrived from the database 
         * is hashed, we have to null it to prevent mistakes in future
         * user password modification.
         */
        $this->setPassword(null);
        
        return $user;
    }
    
    /**
     * Get user by id.
     * 
     * This method is different from {@link read()}, 
     * readAdvanced() uses advanced options.
     * 
     * @param array $allowed Fields to use for matching
     * @return array|null
     */
    public function readAdvanced($allowed = array('id'))
    {
        $user = $this->getMapper(self::DATA_MAPPER_VIEW_SUFFIX)
                     ->read($this, $allowed);
                     
        if (empty($user)) {
            $this->addError($this->translate('User not found'));
            return null;
        }
        
        $this->setOptions($user);
        
        /** 
         * The password, retrived from the database 
         * is hashed, we have to null it to prevent mistakes in future
         * user password modification.
         */
        $this->setPassword(null);
        
        return $user;
    }
    
    /**
     * Delete user(s) by given options.
     * 
     * @return Application_Model_Users
     */
    public function delete()
    {
        $this->getMapper()->delete($this);
        return $this;
    }
    
    /**
     * Add new user to the db.
     * 
     * @return Application_Model_Users
     */
    public function insert()
    {
        $id = $this->getMapper()->insert($this);
        $this->setId($id);
        return $this;
    }
    
    /**
     * Update user.
     * 
     * @return Application_Model_Users
     */
    public function update()
    {
        $this->getMapper()->update($this);
        return $this;
    }
    
    /**
     * Update user.
     * 
     * This method is different from {@link update()}, 
     * updateAdvanced() uses advanced options.
     * 
     * @param boolean $passEmpty Pass the empty options
     * @param array|null $allowed Use options only from this array
     * @return Application_Model_Users
     */
    public function updateAdvanced($passEmpty = false, $allowed = null)
    {
        $this->getMapper()->update($this, $passEmpty, $allowed);
        return $this;
    }
    
    /**
     * Register new user.
     * 
     * @return Application_Model_Users
     */
    public function newUserRegistration()
    {        
        if ($this->_commonSettings->sendEmailActivation) {
            if (!$this->_sendEmailActivation()) {
                $this->addError($this->translate('Error while sending activation e-mail'));
                return $this;
            }
        }
        
        $id = $this->getMapper()->insert($this);
        if (empty($id)) {
            $this->addError($this->translate('Error while registering user in the database'));
            return $this;
        }
        $this->setId($id);        
        return $this;
    }
    
    /**
     * Activate user registration.
     * 
     * @return Application_Model_Users
     */
    public function activate()
    {
        $this->setActive(true);
        $this->getMapper()->activate($this);
        return $this;
    }
    
    /**
     * Send activation message to the user`s e-mail address.
     * 
     * @return boolean
     */
    protected function _sendEmailActivation()
    {
        $this->setActive(false);
        
        /**
         * Generate activation link.
         */
        $siteUrl = 'http://' . $_SERVER['HTTP_HOST'];
        $activationLocation = $siteUrl . $this->url(
                                            array(
                                                'controller' => 'register', 
                                                'action' => 'activate', 
                                                'key' => $this->getKey()
                                            ), 'default'
                                        );
        
        $message = $this->translate('Hello! <br /><br /> You have chosen to register on <a href="%1$s">%2$s</a>. To complete your registration, just click on this link:<br /><br /> <a href="%3$s">%3$s</a> <br /> <br /> User information:<br /> Username: %4$s<br /> E-mail: %5$s<br /> Password: %6$s<br />');
        
        
        $title = sprintf($this->translate('%s - Activating user registration'), strtoupper($_SERVER['HTTP_HOST']));
        
        $body = sprintf($message, $siteUrl, $this->_commonSettings->title, $activationLocation, 
                        $this->getUsername(), $this->getEmail(), $this->getPassword(false));
        
        /**
         * Configure and send the notice
         * message to the user's e-mail
         */
        
		$mail = new Zend_Mail('utf-8');
        
		$mail->setBodyHtml($body);
        
		$mail->setFrom(Zend_Registry::get('COMMON_SETTINGS')->email);
        
		$mail->addTo($this->getEmail());
		$mail->setSubject($title);
		try {
			$mail->send();
		}
		catch(Exception $e){
            return false;
		}
        
        return true;
    }
    
    /**
     * Update user last check time.
     * 
     * @return Application_Model_Users
     */
    public function updateUserLastCheck()
    {
        $this->_roleId = null;
               
        $this->setLastCheck(new Zend_Db_Expr('NOW()'))
             ->getMapper()
             ->update($this, true, array('lastCheck'));
        
        return $this;
    }
    
    /**
     * Remove avatar file.
     * 
     * @param boolean $updateDb Update user avatar in db 
     * @return Application_Model_Users
     * @throws Application_Model_Users_Exception
     */
    public function clearAvatarFile($updateDb = false)
    {
        if (empty($this->_avatar)) {
            return $this;
        }
        
        $avatarsPath = Zend_Registry::get('COMMON_SETTINGS')->user
                                                            ->avatar
                                                            ->path;
        
        if (!is_dir($avatarsPath)) {
            throw new Application_Model_Users_Exception('Avatar path `' . $avatarsPath . '` is wrong');
            
            return $this;
        }
        
        $userAvatarPath = realpath($avatarsPath . '/' . $this->_avatar);
        
        if (!file_exists($userAvatarPath)) {
            return $this;
        }
        
        unlink($userAvatarPath);
        
        /** Update avatar to null in the users database for this user. **/
        if ($updateDb) {
            if (self::checkUserExistence($this->_id)) {
                $this->updateAdvanced(false, array('avatar'));
            } else {
                throw new Application_Model_Users_Exception('User not found or user id is not valid');
            }
        }
        
        return $this;
    }
    
    /**
     * Check is user existing.
     * 
     * @param int $userId
     * @return boolean
     */
    public static function checkUserExistence($userId = null)
    {
        if (empty($userId)) {
            return false;
        }
        
        $usersModel = self::getInstance()->setId($userId);
        $user = $usersModel->read();
        if (empty($user)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Check if $date matches the YYYY-mm-dd pattern
     * 
     * @param string
     * @return boolean
     */
    public static function isDateValid($date)
    {
        if(!preg_match('/^([0-9]{4})(-)?(1[0-2]|0[1-9])(?(2)-)(3[0-1]|0[1-9]|[1-2][0-9])$/', 
                        $date)) {
            return false;
        }        
        return true;
    }
    
    /**
     * Calculates age from given date of birth.
     * 
     * @param string $dateOfBirth
     * @return int|null
     */
    public static function calculateAge($dateOfBirth) 
    {
        if (!self::isDateValid($dateOfBirth)) {
            return null;
        }
        
        list($Y,$m,$d) = explode("-", $dateOfBirth);
        return(date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y);
    }
    
    /**
     * Update user last check time.
     * 
     * @param int $userId
     * @return void
     */
    public static function updateUserLastCheckStatic($userId)
    {
        self::getInstance()->setId($userId)->updateUserLastCheck();
    }
    
    /**
     * Update user last login ip.
     * 
     * @param int $userId
     * @return Application_Model_Users
     */
    public static function updateIpOfLastLogin($userId)
    {
        $model = self::getInstance()->setOptions(array(
            'id' => $userId,
            'ipOfLastLogin' => $_SERVER["REMOTE_ADDR"]
        ));
        return $model->updateAdvanced(true, array('ipOfLastLogin'));
    }
    
    /**
     * Read user by user id.
     * 
     * @param int $userId
     * @return array|null
     */
    public static function readById($userId = null)
    {
        if (empty($userId)) {
            return;
        }
        
        return self::getInstance()->setId($userId)->read();
    }
    
    /**
     * Read field by user id.
     * 
     * @param string $fieldName
     * @param int $userId
     * @return string|null
     */
    public static function readFieldByUserId($fieldName = null, $userId = null)
    {
        if (empty($userId) or empty($fieldName)) {
            return;
        }
        
        $model = self::getInstance()->setId($userId);
        return $model->getMapper(self::DATA_MAPPER_VIEW_SUFFIX)
                     ->readOne($model, array('id'), $fieldName);
    }
    
    /**
     * Read user by username.
     * 
     * @param string $username
     * @return array|null
     */
    public static function readByUsername($username = null)
    {
        if (empty($username)) {
            return;
        }
        
        return self::getInstance()->setUsername($username)
                                  ->readAdvanced(array('username'));
    }
}