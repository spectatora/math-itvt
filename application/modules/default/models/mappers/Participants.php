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
 * @package 	Default Mapper Models
 * @subpackage 	Participants
 * @copyright 	Copyright (c) 2012 Sasquatch MC
 * @version 	$Id$
 */


/**
 * Participants mapper model
 *
 * @category 	Default
 * @package 	Default Mapper Models
 * @subpackage 	Participants
 * @copyright 	Copyright (c) 2012 Sasquatch MC
 */
class Default_Model_Mapper_Participants extends Application_Model_Mapper_DataEntityAbstract
{

    protected $_tableName = 'participants';

	 public function save(Default_Model_Participants $entity)
	{
		 if (empty($entity->id)) {
		    $id = $this->_getGateway()->insert($entity->toArray());
		    $entity->id = $id;
		} else {
		    $this->_getGateway()->update($entity->toArray(), array('id = ?' => $entity->id));
		}
	}

	public function uniqueSchools()
	{
		//$select = $this->_getGateway()->select()->distinct('school');
		$select = $this->_getGateway()->select()->group('school');
 
		$rows = $this->_getGateway()->fetchAll($select);
		return  $rows;
		//return "how are you";
	}

	//unique cities
	public function uniqueCities()
	{
		$select = $this->_getGateway()->select()->group('city');
 
		$rows = $this->_getGateway()->fetchAll($select);
		return  $rows;

	}

	//select all
/*
	public function selectAll($type)
	{
		switch($type) {
			case "participants":
			$select = $this->_getGateway()->select()->where('approved =?', '1');
			break;
			
			case "appearance":
			$select = $this->_getGateway()->select()->where('appearance=?', '1');
			break;
		}
		
		$rows = $this->_getGateway()->fetchAll($select);
		return $rows;
	}
*/

	public function selectAllRegisteredPeople()
	{
		$select = $this->_getGateway()->select()->where('approved =?', '1');

		$rows = $this->_getGateway()->fetchAll($select);
		return $rows;
	}

	public function selectAllParticipants()
	{
		$select = $this->_getGateway()->select()->where('approved =?', '1')->where('appearance','1');

		$rows = $this->_getGateway()->fetchAll($select);
		return $rows;
	}

	public function selectRoomParticipants($room)
	{
//		$select = $this->_getGateway()->select()->where('room =?', $room)->where('approved =?', '1');

		$select = $this->_getGateway()->select()->where('approved =?', '1');

		$rows = $this->_getGateway()->fetchAll($select);
/*
		foreach ($rows as $row) {
			$row->room = $row->findDependentRowset('rooms');
		}
*/
		return $rows;
	}
}

