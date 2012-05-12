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
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: SeoController.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Controller for search engine optimization settings.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controllers
 * @subpackage SEO
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @see        App_Controller_Default_Abstract
 */
class Tulipa_PrintController extends Tulipa_Controller_Action
{
    /**
     * Edit SEO settings.
     * 
     * @return void
     */
    public function indexAction()
    { 
	$this->_helper->layout()->disableLayout();

	$roomvar = $this->_getParam('room', false);

	$this->view->room = $roomvar;


	$model = new Default_Model_Participants();
	//print_r($model->getUniqueSchools());
	

	$roomParticipants = $model->getAllRoomParticipants($roomvar);

	$roomModel = new Default_Model_Rooms();
	$dataRoom = $roomModel->getAllRooms();

	$roomElements =array();

	$counter =0;
	foreach ($roomParticipants as $row) {
//		print_r($row->room);
		foreach ($dataRoom as $roomData) {
			if ($row->room == $roomData->id) {
				$row->room = $roomData->room;
				if ($row->room == $roomvar) {
					$counter++;
					array_push($roomElements,$row);
				}
				
			}
		}
		
	}
	//print_r($roomParticipants);
	//$this->view->roomParticipantsNumber = count($roomParticipants);
	$this->view->roomParticipantsNumber = $counter;
	//$this->view->roomParticipants = $roomParticipants;
	$this->view->roomParticipants = $roomElements;

	$uniqueSchools = $model->getUniqueSchools();
	$this->view->differentSchoolsNumber = count($uniqueSchools);
	$this->view->uniqueSchools = $uniqueSchools;


	//unique cities
	$uniqueCities = $model->getUniqueCities();
	$this->view->differentCitiesNumber = count($uniqueCities);
	$this->view->uniqueCities = $uniqueCities;

	$this->view->message = "Статистика <br />";

	
	//approved people
	$approvedEntries = $model->getAllRegisteredPeople();
	//print_r($approvedEntries);
	$this->view->approvedEntriesNumber = count($approvedEntries);
	$this->view->approvedEntries = $approvedEntries;

	
	//approved and appeared people
	$appearedEntries = $model->getAllParticipants();
	$this->view->appearedEntriesNumber = count($appearedEntries);
	$this->view->appearedEntries = $appearedEntries;
	//$this->view->message = $model->getUniqueSchools();


    }

    public function scheduleAction()
    {
	$model = new Default_Model_Participants();
	 //approved people
	$approvedEntries = $model->getAllRegisteredPeople();

	$roomModel = new Default_Model_Rooms();
	$dataRoom = $roomModel->getAllRooms();

	foreach ($approvedEntries as $row) {
//		print_r($row->room);
		foreach ($dataRoom as $roomData) {
			if ($row->room == $roomData->id) {
				$row->room = $roomData->room;
			}
		}
		
	}

	//print_r($approvedEntries);
	$this->view->approvedEntriesNumber = count($approvedEntries);
	$this->view->approvedEntries = $approvedEntries;
    }

    public function ratingAction()
    {
	$model = new Default_Model_Participants();
	//approved and appeared people
	$appearedEntries = $model->getAllParticipants();

	$this->view->appearedEntriesNumber = count($appearedEntries);
	$this->view->appearedEntries = $appearedEntries;
    }
}
