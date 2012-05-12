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
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: L10n.php 103 2011-04-18 13:41:08Z sasquatch@bgscripts.com $
 */

/**
 * Localization model.
 * 
 * @category   Application
 * @package    Application_Models
 * @subpackage Localization
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
class Application_Model_L10n
{
    /**
     * Browse countries/cities static method.
     * 
     * @param string $classToInstantiate Name of the l10n component
     * @param array $options 
     * @return array
     */
    public static function browse($classToInstantiate = null, $options = null)
    {
        if (null === $classToInstantiate) {
            return;
        }
        $model = self::factory($classToInstantiate, $options);
        if (!empty($model)) {
            return $model->browse();
        }
    }
    
    /**
     * Factory method.
     * 
     * Get instance of a specific l10n Component. 
     * Implements the {@link http://en.wikipedia.org/wiki/Factory_method_pattern Factory Method} Design Pattern.
     * 
     * @param string $classToInstantiate Name of the l10n component
     * @param array $options 
     * @return Application_Model_L10n_Abstract|void
     */
    public static function factory($classToInstantiate = null, $options = null)
    {
        if (null === $classToInstantiate) {
            return;
        }
        
        if (!is_string($classToInstantiate)) {
            return;
        }
        
        /**
         * Format the new class name.
         */
        $className = 'Application_Model_L10n_' . ucfirst($classToInstantiate);
        
        $pathSuffix = Zend_Filter::filterStatic(
            $classToInstantiate, 'Word_UnderscoreToSeparator', 
            array('replacementSeparator' => DIRECTORY_SEPARATOR));
        
        $classFilePath = APPLICATION_PATH . '/models/L10n/' 
                         . ucfirst($pathSuffix) 
                         . '.php';
        
        /**
         * Check for class existance.
         */        
        if (!class_exists($className)) {
            return;
        }
        
        $object = new $className;      
        
        if ($object instanceof Application_Model_Abstract & null !== $options) {
            $object->setOptions($options);
        }
        
        return $object;        
    }
}