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
class Default_Model_Mapper_Rooms extends Application_Model_Mapper_DataEntityAbstract
{

    protected $_tableName = 'rooms';

	public function selectRoomParticipants()
	{

		$select = $this->_getGateway()->select();
		//$select = $this->_getGateway()->find(1234);

		$rows = $this->_getGateway()->fetchAll($select);
		return $rows;
	}
}

