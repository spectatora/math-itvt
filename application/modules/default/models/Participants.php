<?php
/**
 * phpAbility © 
 * Copyright © 2012 Sasquatch <Joan-Alexander Grigorov>
 *                      http://bgscripts.com
 *
 * LICENSE
 *
 * A copy of this license is bundled with this package in the file LICENSE.txt.
 *
 * Copyright © phpAbility
 *
 * Platform that uses this site is protected by copyright.
 * It is provided solely for the use of this site and all its copying,
 * processing or use of parts thereof is prohibited and pursued by law.
 *
 * All rights reserved. Contact: office@bgscripts.com
 *
 * @category 	Default
 * @package 	Default Models
 * @subpackage 	Participants
 * @copyright 	Copyright (c) 2012 Sasquatch MC
 * @version 	$Id$
 */


/**
 * Participants model
 *
 * @category 	Default
 * @package 	Default Models
 * @subpackage 	Participants
 * @copyright 	Copyright (c) 2012 Sasquatch MC
 * @method 		Default_Model_Mapper_Participants _getMapper()
 */
class Default_Model_Participants extends Application_Model_DataEntityAbstract
{

    protected $_mapperName = 'Default_Model_Mapper_Participants';

    protected $_data = array(
        'id' => null,
        'names' => null,
        'city' => null,
        'school' => null,
        'grade' => null,
        'level' => null,
        'teacher' => null,
        'address' => null,
        'email' => null,
        'phone' => null,
        'approved' => 0,
//        'room' => 0,
        'appearance' => 0,
        'points' => 0,
        'inRating' => 0
/*
	'recaptcha_challenge_field' => null,
	'recaptcha_response_field' => null,
	'formSubmit' => null,
	'controller' => null,
	'action' => null,
	'module' => null
*/
        );

	 protected $_referenceMap = array(
        'rooms' => array(
            'columns'    => array('room'),
            'refTable'   => 'rooms',
            'refColumns' => array('id')
        ),
    );

	 public function add()
	{
	    $this->id = null;
	    $this->_getMapper()->save($this);
	    return $this;
	}

	public function save()
	{
	    $this->_getMapper()->save($this);
	    return $this;
	}

	//get schools
	public function getUniqueSchools()
	{
		return $this->_getMapper()->uniqueSchools();
	}

	//get cities
	public function getUniqueCities()
	{
		return $this->_getMapper()->uniqueCities();
	}

	//all registered people with approved ==1;
	public function getAllRegisteredPeople()
	{
		return $this->_getMapper()->selectAllRegisteredPeople();
	}

	//all participants (approved==1 and apperance==1)
	public function getAllParticipants()
	{
		return $this->_getMapper()->selectAllParticipants();
	}

	//all room participants (room =)
	public function getAllRoomParticipants($room)
	{
		return $this->_getMapper()->selectRoomParticipants($room);
	}
}

