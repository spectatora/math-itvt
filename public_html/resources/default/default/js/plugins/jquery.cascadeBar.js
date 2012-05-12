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
 */

jQuery.fn.cascadeBar = function()
{        
    return this.each(function() {
        if ($(this).hasClass('interface-body-bar')) {
            $('.ui-widget-header', this).click(function() {
                var element = $(this);
                var content = $(this).next();
                
                if (content.css('display') == 'none') {
                    element.toggleClass('ui-state-default ui-corner-all').toggleClass('ui-state-active ui-corner-top');
                    content.slideDown();
                } else {
                    content.slideUp(function() {
                        element.toggleClass('ui-state-default ui-corner-all').toggleClass('ui-state-active ui-corner-top');
                    });
                }
            });
        }
    });
};