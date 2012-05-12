/**
 * Tulipa Lite
 * Copyright (C) 2010 Sasquatch <Joan-Alexander Grigorov>
 *                      http://bgscripts.com
 * 
 * LICENSE
 * 
 * This source file is created by Joan-Alexander Grigorov (office@bgscripts.com).
 * Note that this is not an open source or freeware project.
 *
 * @category   Tulipa
 * @package    Tulipa_Controller
 * @subpackage Main
 * @copyright  Copyright (c) 2010 Sasquatch MC
 * @version    $Id: main.js 186 2011-09-22 21:48:27Z sasquatch@bgscripts.com $
 */

/**
 * Main controller.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controller
 * @subpackage Main
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
var mainController = {
    
    location : null,
    
    iconTemp : null,
    
    currentLink : null,
    
    loadingWindow : '#loadingWindow',
    
    loadingAnimation : '<p class="loading"><img src="' + baseResourcesUrl('images/loading.png') + '" /></p>',
    
    displayLoadingModal : function() 
    {
        var modal = $('#content .modal'),
            content = $('#content .content'),
            offset = content.offset();
        
        if (modal.length === 0) {
            modal = $('<div/>');
            modal.addClass('modal ui-corner-bottom ui-widget-overlay')
                 .html(mainController.loadingAnimation)
                 .fadeTo(0, 0);
            content.append(modal);
        }
        
        modal.width(content.outerWidth())
             .height(content.outerHeight())
             .css({
                'top' : offset.top,
                'left' : offset.left
             });
        
        modal.fadeTo('slow', 0.5);
        
        /**
         * Change the bar icon.
         */
        $('#content div.top img').attr('src', baseResourcesUrl('images/loading03.gif'));
    },
    
    /**
     * @return void
     */
    hideLoadingModal : function()
    {
    	$('#content .modal').hide();
        $('#content div.top img').attr('src', baseResourcesUrl('icons/24x24/edit.png'));
    },
    
    displayLoadingWindow : function()
    {
        if ($(this.loadingWindow).length === 0) {
            var confirm = $('<div/>').attr('id', 'loadingWindow');
            $('body').append(confirm);
        }
        
        var parent = this;
        
        var loadingWindow = $(this.loadingWindow);
        loadingWindow.html(recordRemover.loadingAnimation)
                     .dialog({
                        resizable: false,
                        title: translate('Моля изчакайте'),
                        height: 63,
                        width: 350,
            			modal: true,
                        open: function() {
                            $('div.document').next('.ui-widget-overlay').hide().fadeTo('fast', 0.8);
                        }
                     })
                     .dialog('open');
    },
    
    hideLoadingWindow : function()
    {
        $(this.loadingWindow).dialog('close');
    },
    
    refreshButtons : function()
    {
        /** Buttons with icons. **/
        $('.iconButton').each(function(){
           if (!$(this).hasClass('ui-button')) {     
                var className = $(this).attr('class');
                className = className.replace(/iconButton/, '');
                className = jQuery.trim(className);
                
                if (className) {
                    if (!$(this).html()) {
                        $(this).button({ text: false });
                    }
                    $(this).button({ icons: {primary:'ui-icon-' + className} });
                } else {
                    $(this).button();
                }
           }
        });
    },
    
    refreshMenus : function()
    {
        $('ul.navigation li a').click(function() {
            $('ul.navigation li a').removeClass('focus');
            $(this).addClass('focus');
        });
    },
    
    refreshLanguageBar : function()
    {
        $('.languageIcon:not(.ui-state-active)').hover(function() {
            $(this).addClass('ui-state-hover');
        }, function() {
            $(this).removeClass('ui-state-hover');
        }).mousedown(function() {
            $(this).addClass('ui-state-active');
        }).mouseup(function() {
            $(this).removeClass('ui-state-active');
        });  
    },
    
    /**
     * @param mixed callback
     * @return void
     */
    preDispatch : function(callback)
    {        
        this.iconTemp = null;
        this.displayLoadingModal();
        
        if (callback != null) {
            callback();
        }
    },
    
    /**
     * @param string response
     * @return void
     */
    postDispatch : function(response)
    {        
        var content = $('#content div.content'),
            modal = $('#content .modal');
        content.html(response);
        this.dispatchForms();
        this.refreshLinks(content);
        this.refreshButtons();
        
        $('#content div.top img').attr('src', baseResourcesUrl('icons/24x24/edit.png'));
    },
    
    refreshLinks : function(target)
    {
        var parent = this;
        $('a:not(.noJs)', target).not('.cke_browser_webkit a, .textboxlist-bit-box-deletebutton').each(function(){
            if (!$(this).hasClass('delete')) {
                var link = $(this).attr('href');
                if (link) {
                    $(this).click(function() {
                        parent.dispatch(link);
                        return false;
                    });
                }
            }
        });
        
        return this;
    },
    
    /**
     * Open page with ajax.
     * 
     * @param string link
     * @return void
     */
    dispatch : function(link)
    {
        var newLocation = this.location + '#' + link;
        
        if (this.currentLink == null) {
            window.location = newLocation;
            this.currentLink = link;
        } else {
            if (link != this.currentLink) {
                this.currentLink = link;
                window.location = newLocation;
            } else {
                return;
            }
        }
        
        var content = $('#content div.content'),
            parent = this;
        
        this.preDispatch(function() {
            $.get(link, function(response) {
                parent.postDispatch(response);
            });
        });
        
        var breadcrumbs = $('#breadcrumbs');
                
        $.post(baseUrl('/admin/ajax/'), { 'url' : baseUrl(link) }, function(response) {
            breadcrumbs.after(response['breadcrumbs']).remove();
            $('title').text(response['pageTitle']);
            content.parent().find('div.top a').html(response['pageName']);
            parent.refreshLinks($('#breadcrumbs'));
        });
        
        return this;
    },
    
    /**
     * Process form with ajax.
     * 
     * @param string link
     * @return void
     */
    dispatchForms : function()
    {
        var parent = this;
        
        var options = {
            beforeSubmit: function() {
                parent.preDispatch();
            },
            success: function(data) {
                parent.postDispatch(data);
            }
        };
        
        $('form').each(function(){
            if ($(this).attr('enctype') == 'multipart/form-data') {
                options.iframe = true;
                options.iframeSrc = $(this).attr('action');
                options.target = $('#content div.content');
            } else {
                options.iframe = false;
                options.iframeSrc = null;
                options.target = null;
            }
            $(this).ajaxForm(options);
        });
        
        return this;
    },
    
    historyCheck : function()
    {
        if (null != this.currentLink && window.location.hash.length != 0) {
            if (this.currentLink != window.location.hash.substr(1)) {
                this.dispatch(window.location.hash.substr(1));
                return;
            }
        }
    }
};

$(document).ready(function() {
    var hash = window.location.hash;
    mainController.location = window.location.pathname;
    mainController.currentLink = window.location.pathname;
    if (hash.length > 1) {
        var link = hash.substr(1);
        mainController.dispatch(link);
    }
});