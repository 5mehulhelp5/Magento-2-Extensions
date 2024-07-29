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
 * @package    Magexperts_LazyImageLoader
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
define([
    'jquery',
    'bss/unveil'
], function ($) {
    'use strict';
    $.widget('bss.bss_config', {
        _create: function () {
            var options = this.options;
            var threshold = parseInt(options.threshold);

            $(document).ready(function() {
                $("img.lazy").unveil(threshold);
            });

        }
    });
    return $.bss.bss_config;
});
