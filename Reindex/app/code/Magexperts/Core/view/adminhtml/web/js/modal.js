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
    'jquery',
    'jquery/ui',
    'Magento_Ui/js/modal/modal'
], function ($) {

    $.widget('mage.modal', $.mage.modal, {
        // Fix bug Modal close on Magento 2.2.0

        /**
         * Set z-index and margin for modal and overlay.
         */
        _setActive: function () {
            var zIndex = this.modal.zIndex(),
                baseIndex = zIndex + this._getVisibleCount();

            if (this.modal.data('active')) {
                return;
            }

            this.modal.data('active', true);

            this.overlay.zIndex(++baseIndex);
            this.prevOverlayIndex = this.overlay.zIndex();
            this.modal.zIndex(this.overlay.zIndex() + 1);

            if (this._getVisibleSlideCount()) {
                this.modal.css('marginLeft', this.options.modalLeftMargin * this._getVisibleSlideCount());
            }
        },

        /**
         * Unset styles for modal and set z-index for previous modal.
         */
        _unsetActive: function () {
            this.modal.removeAttr('style');
            this.modal.data('active', false);

            if (this.overlay) {
                this.overlay.zIndex(this.prevOverlayIndex - 1);
            }
        },
    });

    return $.mage.modal;
});
