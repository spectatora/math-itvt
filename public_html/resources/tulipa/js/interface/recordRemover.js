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
 * @version    $Id: recordRemover.js 185 2011-09-22 14:49:32Z sasquatch@bgscripts.com $
 */

/**
 * Record remover model.
 * 
 * @category   Tulipa
 * @package    Tulipa_Controller
 * @subpackage Main
 * @copyright  Copyright (c) 2010 Sasquatch MC
 */
var recordRemover = {
    
    loadingAnimation : '<p class="loading"><img src="' + baseResourcesUrl('images/loading02.gif') + '" /></p>',
    
    confirmWindow: '#confirmWindow',
    
    remove: function(options)
    {
        var settings = jQuery.extend({
            url: null,
            confirmMessage: translate('Сигурен ли сте, че искате да извършите тази опирация?'),
            elementToHide: null
        }, options);
        
        var confirmMessageState = $('<div/>').html(settings.confirmMessage)
                                             .stateInfo();
        
        if (null === settings.url || null === settings.elementToHide) {
            return;
        }
        
        if ($(this.confirmWindow).length === 0) {
            var confirm = $('<div/>').attr('id', 'confirmWindow');
            $('body').append(confirm);
        }
        
        var parent = this;
        
        var confirmWindow = $(this.confirmWindow);
        confirmWindow.html(confirmMessageState)
                     .dialog({
                        resizable: false,
                        title: translate('Потвърждение'),
                        maxHeight: 300,
                        height: 150,
                        width: 350,
                        minWidth: 345,
                        maxWidth: 400,
            			modal: true,
                        open: function() {
                            $('div.document').next('.ui-widget-overlay').hide().fadeTo('fast', 0.8);
                        },
                        buttons: {
            				'Delete': function() {
            				    var loadingAnimation = $('<p/>').html(parent.loadingAnimation);
                                    loadingAnimation.addClass('textAlignCenter');
                                
            				    $(this).html(loadingAnimation)
                                       .dialog({
                                            buttons: null,
                                            height: 63
                                       });
                                parent._remove(settings);
            				},
            				'Cancel': function() {
            					$(this).dialog('close');
            				}
            			}
                     })
                     .dialog('open');
    },
    
    _remove: function(options)
    {
        var settings = jQuery.extend({
            url: null,
            elementToHide: null
        }, options),
            messageSuccess = translate('Записът е изтрит успещно'),
            messageError = translate('Грешка!'),
            confirmWindow = $(this.confirmWindow)
            hasErrors = false;
        
        if (null === settings.url || null === settings.elementToHide) {
            return;
        }
        
        $.post(settings.url, function(response) {
            if (response.length > 0) {
                var messagesLength = response.length;
                confirmWindow.html('');
                for (var i = 0; i < messagesLength; i++)
                {
                    var messageElement = $('<div/>');
                        messageElement.html(response[i]['message']);
                    if (!response[i]['isError']) {
                        messageElement.stateCheck();
                    } else {
                        messageElement.stateError();
                        hasErrors = true;
                    }
                    confirmWindow.append(messageElement);
                }
            } else {
                confirmWindow.html(messageSuccess);
            }
            
            confirmWindow.dialog({
                buttons: {
                    'Close': function() {
    					$(this).dialog('close');
    				}
                },
                close: function() {
                    if (null !== settings.elementToHide & !hasErrors) {
                        $('#' + settings.elementToHide).fadeOut('slow');
                    }
                },
                height: 'auto'
            });
        });
    }
}