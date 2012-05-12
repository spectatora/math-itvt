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
class Tulipa_BlankController extends Tulipa_Controller_Action
{
    /**
     * Edit SEO settings.
     * 
     * @return void
     */
    public function indexAction()
    { 
	 $request = $this->getRequest();
        
        $form = new Tulipa_Form_PrintForm;
        
        $this->view->form = $form;
        
        if ($request->isPost()) {
            
            if ($form->isValid($request->getPost())) {
             //$this->view->selectedElement = $form->getValue('purpose');
		$i = $form->getValue('purpose');
		switch ($i) {
		    case 1:
			//schedule
			$this->_helper->redirector->gotoRouteAndExit(array(
		                    'controller' => 'print',
		                    'action' =>'schedule'
		                ), 'tulipa', true
		            );
			$this->view->selectedElement = "i equals 1";
			break;
		    case 2:
			$this->_redirect('admin/print/index/room/'.$form->getValue('room'));

			//$this->view->selectedElement = "i equals 2";
			break;
		    case 3:
			$this->view->selectedElement = "i equals 3";
			break;
		}
            }
            
        }
	/*
	$model = new Default_Model_Participants();
	//print_r($model->getUniqueSchools());
	
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
	
/*

    	$settingsModel = new Default_Model_Settings;
        $form = new Tulipa_Form_Seo;
        
        $form->populate($settingsModel->browseReadyForForm());
        $this->view->form = $form;
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$settings = $form->getValues();
        		

        		foreach ($settings as $name => $content) {
        			$settingsModel->setName($name)
        			              ->setContent($content)
        			              ->update();
        		}
        		
        		$this->status($this->translate('Information successfully updated'));
        	}
        }
*/
    }
}
