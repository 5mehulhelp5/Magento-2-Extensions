/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

/*jshint jquery:true*/
define([
    'jquery',
    'underscore',
    'mage/template',
    'uiRegistry',
    'productGallery',
    'jquery-ui-modules/core',
    'jquery-ui-modules/widget',
    'baseImage'
], function ($, _, mageTemplate, registry, productGallery) {
    'use strict';

    $.widget('mage.productGallery', $.mage.productGallery, {
        _showDialog: function (imageData) {}
    });

    return $.mage.productGallery;
});
