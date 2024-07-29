/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category  Magexperts
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (jQuery, ko, Component, customerData) {
    'use strict';
    return Component.extend({
        initialize: function () {
            var self = this;
            self._super();
            customerData.get('bss-fbpixel-subscribe').subscribe(function (loadedData) {
                if (loadedData && "undefined" !== typeof loadedData.events) {
                    for (var eventCounter = 0; eventCounter < loadedData.events.length; eventCounter++) {
                        var eventData = loadedData.events[eventCounter];
                        if ("undefined" !== typeof eventData.eventAdditional && eventData.eventAdditional) {
                            jQuery('.bss-subscribe-email').text(eventData.eventAdditional.email);
                            jQuery('.bss-subscribe-id').text(eventData.eventAdditional.id);
                            customerData.set('bss-fbpixel-subscribe', {});
                            return window.fb();
                        }
                    }
                }
            });
        }
    });
});
