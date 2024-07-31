/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

define([
    'Magento_Ui/js/form/element/select',
], function (select) {
    'use strict';

    return select.extend({
        defaults: {
            customName: '${ $.parentName }.${ $.index }_input',
            elementTmpl: 'Magexperts_ProductLabel/form/element/position',
            caption: '',
            options: []
        },

        onElementRender: function () {
            document.body.setAttribute(this.index, this.value());

            if (typeof LabelHelper === 'undefined') {
                return;
            }

            var self = this;

            let waitOnPreview = setInterval(function () {
                if (LabelHelper.getSectionWrapper(self).querySelector(LabelHelper._previewSelector)) {
                    clearInterval(waitOnPreview);
                    self.updatePositionInPreview(self.value());
                }
            }, 100);
        },

        onUpdate: function () {
            this._super();
            document.body.setAttribute(this.index, this.value());
            this.updatePositionInPreview(this.value())
        },

        updatePositionInPreview: function (position) {
            if (typeof LabelHelper === 'undefined') {
                return;
            }

            let newClasses = 'mf-label mf-label-position-' + position;
            LabelHelper.getSectionWrapper(this).querySelector(LabelHelper._previewSelector).className = newClasses;
        }
    });
});
