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
class Default_Model_Rooms extends Application_Model_DataEntityAbstract
{

    protected $_mapperName = 'Default_Model_Mapper_Rooms';

    protected $_data = array(
        'id' => null,
        'room' => 0,
        );

	//all room participants (room =)
	public function getAllRooms()
	{
		return $this->_getMapper()->selectRoomParticipants();
	}
}

