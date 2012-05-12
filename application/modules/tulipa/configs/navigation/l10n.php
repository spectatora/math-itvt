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
 * @package    Tulipa_Navigation
 * @subpackage Main
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: l10n.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Navigation menu container array.
 */
return array(
    array(
        'label'         => Application_Model_Translate::translate("L10n/I18n"),
        'route'         => 'tulipa',
        'pages'         => array (
            array(
                'label'         => Application_Model_Translate::translate("Languages"),
                'module'        => 'tulipa',
                'controller'    => 'langs',
                'route'         => 'tulipa',
        		'resource'		=> 'tulipa::langs',
                'pages'         => array(
                    array(
                        'label'         => Application_Model_Translate::translate("New language"),
                        'module'        => 'tulipa',
                        'controller'    => 'langs',
                        'action'        => 'add',
        				'resource'		=> 'tulipa::langs',
        				'privilege'		=> 'add',
                    ),
                    array(
                        'label'         => Application_Model_Translate::translate("Converter"),
                        'module'        => 'tulipa',
                        'controller'    => 'langs',
                        'action'        => 'converter',
        				'resource'		=> 'tulipa::langs',
        				'privilege'		=> 'converter'
                    ),
                    array(
                        'label'         => Application_Model_Translate::translate("Language update"),
                        'module'        => 'tulipa',
                        'controller'    => 'langs',
                        'action'        => 'edit',
                        'class'         => 'hidden',
        				'resource'		=> 'tulipa::langs',
        				'privilege'		=> 'edit'
                    ),
                )
            ),
            array(
                'label'         => Application_Model_Translate::translate("Countries"),
                'module'        => 'tulipa',
                'controller'    => 'countries',
                'route'         => 'tulipa',
				'resource'		=> 'tulipa::countries',
                'pages'         => array(
                    array(
                        'label'         => Application_Model_Translate::translate("New country"),
                        'module'        => 'tulipa',
                        'controller'    => 'countries',
                        'action'        => 'add',
        				'resource'		=> 'tulipa::countries',
        				'privilege'		=> 'add'
                    ),
                    array(
                        'label'         => Application_Model_Translate::translate("Country update"),
                        'module'        => 'tulipa',
                        'controller'    => 'countries',
                        'action'        => 'edit',
                        'class'         => 'hidden',
        				'resource'		=> 'tulipa::countries',
        				'privilege'		=> 'edit'
                    ),
                )
            ),
            array(
                'label'         => Application_Model_Translate::translate("Cities"),
                'module'        => 'tulipa',
                'controller'    => 'cities',
				'resource'		=> 'tulipa::cities',
                'route'         => 'tulipa',
                'pages'         => array(
                    array(
                        'label'         => Application_Model_Translate::translate("New city"),
                        'module'        => 'tulipa',
                        'controller'    => 'cities',
                        'action'        => 'add',
        				'resource'		=> 'tulipa::cities',
        				'privilege'		=> 'add'
                    ),
                    array(
                        'label'         => Application_Model_Translate::translate("City update"),
                        'module'        => 'tulipa',
                        'controller'    => 'cities',
                        'action'        => 'edit',
                        'class'         => 'hidden',
        				'resource'		=> 'tulipa::cities',
        				'privilege'		=> 'edit'
                    ),
                )
            )
        )
    )
);