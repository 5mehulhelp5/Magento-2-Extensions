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
 * @category   Magexperts
 * @package    Magexperts_Core
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

define([
    "jquery",
    "Magento_Ui/js/modal/modal",
    "mage/cookies",
    "domReady!"
], function ($, modal) {
    "use strict";

    $.widget('magexperts.popup', {

        /**
         * @private
         */

        _init: function () {

            var $widget = this,
                cookie = 'first-visit',
                options = {
                    type: 'popup',
                    innerScroll: true,
                    title: $.mage.__(this.options.title),
                    modalClass: "magexperts-popup",
                    autoOpen: false,
                    responsive: true,
                    clickableOverlay: true,
                };

            if (this._isCookieSet(cookie) != true) {
                $widget._openModal(options, cookie);
            }
        },

        /**
         * Open Modal and set cookie
         *
         * @param options
         * @param cookie
         * @private
         */

        _openModal: function (options, cookie) {

            var html = this.element;
            modal(options, html);

            setTimeout(function () {
                html.modal('openModal')
            }, this.options.delay);

            this._setCookie(cookie);
        },

        /**
         * Set cookie
         *
         * @param cookie
         * @private
         */

        _setCookie: function (cookie) {
            $.mage.cookies.set(cookie, true);

        },

        /**
         * Check if cookie is set
         *
         * @param cookie
         * @returns {boolean}
         * @private
         */

        _isCookieSet: function (cookie) {
            if ($.mage.cookies.get(cookie) == "true") {
                return true;
            }
        }

    });

    return $.magexperts.popup;
});