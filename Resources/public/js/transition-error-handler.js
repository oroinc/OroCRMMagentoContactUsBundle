/*global define*/
define([
    'jquery',
    'oroui/js/messenger',
    'orotranslation/js/translator'
], function ($, messenger, __) {
        'use strict';

        /**
         * Transition error handler
         *
         * @export  orocrm/magentocontactus/transition-error-handler
         * @class   orocrm.transitionErrorHandler
         */
        return {
            handleEmailTransitionError: function() {
                var element = $('[id^=transition-orocrm_contact_us_contact_request-send_email]');
                element.off('transitions_failure');
                element.on('transitions_failure', function(event, jqxhr){
                    if (jqxhr.status != 500) {
                        return;
                    }
                    event.stopImmediatePropagation();
                    event.preventDefault();
                    messenger.notificationFlashMessage('error', __('oro.email.handler.unable_to_send_email'));
                });
            }
        }
    }
);
