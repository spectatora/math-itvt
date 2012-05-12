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
 * @version    $Id: main.php 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Navigation menu container array.
 */
return array(
    array(
        'label'         => Application_Model_Translate::translate("Main menu"),
        'module'        => 'tulipa',
        'pages'         => array (
            array(
                'label'         => Application_Model_Translate::translate("Home"),
                'controller'    => 'index',
                'action'        => 'index',
                'route'         => 'tulipa',
        		'resource'		=> 'tulipa::index',
            ),
            array(
                'label'         => Application_Model_Translate::translate("Login"),
                'module'        => 'tulipa',
                'controller'    => 'login',
                'action'        => 'index',
                'route'         => 'tulipa',
                'class'         => 'hidden',
        		'resource'		=> 'tulipa::login',
            ),
		//statistics
	     array(
                'label'         => 'Статистика',
                'module'        => 'tulipa',
                'controller'    => 'statistics',
                'action'        => 'index',
                'route'         => 'tulipa',
        		'resource'		=> 'tulipa::statistics',
            ),

	//blank
	     array(
                'label'         => 'Форми',
                'module'        => 'tulipa',
                'controller'    => 'blank',
                'action'        => 'index',
                'route'         => 'tulipa',
        		'resource'		=> 'tulipa::blank',
            ),

            array(
                'label'         => Application_Model_Translate::translate("SEO"),
                'module'        => 'tulipa',
                'controller'    => 'seo',
                'route'         => 'tulipa',
				'resource'		=> 'tulipa::seo',
            ),
            array(
                'label'         => Application_Model_Translate::translate("Users"),
                'module'        => 'tulipa',
                'controller'    => 'users',
                'route'         => 'tulipa',
        		'resource'		=> 'tulipa::users',
                'pages'         => array(
                    array(
                        'label'         => Application_Model_Translate::translate("New user"),
                        'module'        => 'tulipa',
                        'controller'    => 'users',
                        'action'        => 'add',
        				'resource'		=> 'tulipa::users',
        				'privilege'		=> 'add'
                    ),
                    array(
                        'label'         => Application_Model_Translate::translate("User update"),
                        'module'        => 'tulipa',
                        'controller'    => 'users',
                        'action'        => 'edit',
                        'class'         => 'hidden',
        				'resource'		=> 'tulipa::users',
        				'privilege'		=> 'edit'
                    )
                )
            )
        )
    )
);
