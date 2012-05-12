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
 * @version    $Id: rules.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */
 
/**
 * Navigation menu container array.
 */
return array(
    array(
        'label'         => Application_Model_Translate::translate("Access"),
        'route'         => 'tulipa',
        'pages'         => array (
            array(
                'label'         => Application_Model_Translate::translate("Roles"),
                'module'        => 'tulipa',
                'controller'    => 'roles',
                'route'         => 'tulipa',
    			'resource'		=> 'tulipa::roles',
                'pages'         => array(
                    array(
                        'label'         => Application_Model_Translate::translate("New role"),
                        'module'        => 'tulipa',
                        'controller'    => 'roles',
                        'action'        => 'add',
    					'resource'		=> 'tulipa::roles',
                        'privilege'		=> 'add'
                    ),
                    array(
                        'label'         => Application_Model_Translate::translate("Role edit"),
                        'module'        => 'tulipa',
                        'controller'    => 'roles',
                        'action'        => 'edit',
                        'class'         => 'hidden',
    					'resource'		=> 'tulipa::roles',
                        'privilege'		=> 'edit'
                    )
                )
            ),
            array(
                'label'         => Application_Model_Translate::translate("Access Control List"),
                'module'        => 'tulipa',
                'controller'    => 'acl',
				'resource'		=> 'tulipa::acl',
                'route'         => 'tulipa',
                'pages'         => array(
                    array(
                        'label'         => Application_Model_Translate::translate("New rule"),
                        'module'        => 'tulipa',
                        'controller'    => 'acl',
                        'action'        => 'add',
    					'resource'		=> 'tulipa::acl',
                        'privilege'		=> 'add'
                    )
                )
            )
        )
    )
);