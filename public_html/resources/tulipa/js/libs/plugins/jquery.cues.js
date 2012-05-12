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
 * jquery.cues.js
 * @author Sasquatch <Joan-Alexander Grigorov>
 *
 * Plugins for generating interaction Cues.
 *
 */

/** Info cue. **/
jQuery.fn.stateInfo = function()
{
    return this.each(function(){

        var content = $(this).html();
        
        $(this).html('<div class="ui-widget"><div class="ui-state-highlight ui-corner-all ui-state"><p><span class="ui-icon ui-icon-info"></span>' + content + '</p></div></div>');
    
    });
    
};

/** Error cue. **/
jQuery.fn.stateError = function()
{
    return this.each(function(){
        
        var content = $(this).html();
                
        $(this).html('<div class="ui-widget"><div class="ui-state-error ui-corner-all ui-state"><p><span class="ui-icon ui-icon-alert"></span>' + content + '</p></div></div>');
        
    });
};

/** Success cue. **/
jQuery.fn.stateCheck = function()
{
    return this.each(function(){
        
        var content = $(this).html();
        
        $(this).html('<div class="ui-widget" style="display: inline"><div class="ui-state-highlight ui-corner-all ui-state"><p><span class="ui-icon ui-icon-check"></span>' + content + '</p></div></div>');
        
    });
};