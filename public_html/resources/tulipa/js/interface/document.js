/**
 * Main JavaScript file for configuring Tulipa Lite interface.
 */
$(document).ready(function(){
    /** Remove hidden navigation items. **/
    $('ul.navigation li a.hidden').parent().remove();
    /** Add some dynamics on bars **/
    $('div.bar div.top a, div.bar div.top span.arrow').toggle(function() {
        var parent = $(this).parent().parent(),
            top = parent.children('div.top');
        parent.children('div.content').slideUp('fast');
        parent.find('div.top span').toggleClass('right');
        top.toggleClass('ui-corner-all').toggleClass('inactive');
    }, function() {
        var parent = $(this).parent().parent(),
            top = parent.children('div.top');
        parent.children('div.content').slideDown('fast');
        parent.find('div.top span').toggleClass('right');
        top.toggleClass('ui-corner-all').toggleClass('inactive');
    });
    
    
    mainController.refreshLinks($('.navigation'));
    mainController.refreshLinks($('.crud-module-icon'));
    mainController.dispatchForms();
    mainController.refreshButtons();
    mainController.refreshLanguageBar();
    mainController.refreshMenus();
    
    setInterval(function() {
        mainController.historyCheck();
    }, 100);
});