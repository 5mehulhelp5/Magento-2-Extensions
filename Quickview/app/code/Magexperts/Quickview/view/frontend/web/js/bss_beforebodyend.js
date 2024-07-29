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
 * @package    Magexperts_Quickview
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
define(
    [
    'jquery',
    'underscore',
    'Magento_Ui/js/modal/modal'
],
    function ($) {
    $.widget(
        'bss.bss_beforebodyend',
        {
            _create: function () {
                var options = this.options;
                var showReview = options.removeReview;
                var showMoreInfo = options.removeMoreInfo;
                $(document).ready(
                    function () {

                        var documentPadding = 10;
                        var firstAttempt = true;
                        var lastHeight = 0, curHeight = 0;

                        var parentBody = window.parent.document.body;
                        $('.mfp-preloader', parentBody).css('display', 'none');
                        $('.mfp-iframe-holder .mfp-content', parentBody).css('width', '100%');

                        $('.mfp-iframe-scaler iframe', parentBody).animate({'opacity': 1}, 2000);
                        $('.reviews-actions a').attr('target', '_parent');
                        $('.product-social-links a').attr('target', '_parent');
                        $('body').css('overflow', 'hidden');

                        setInterval(
                            function ()
                            {
                                if (firstAttempt) {
                                    curHeight = $('.page-wrapper .columns').outerHeight(true) + documentPadding;
                                } else {
                                    curHeight = $('.page-wrapper .columns').outerHeight(true);
                                }
                                documentHeight = curHeight + "px";
                                if (curHeight != lastHeight) {
                                    $(
                                        '.mfp-iframe-holder .mfp-content',
                                        parentBody
                                    ).animate(
                                        {
                                            'height': documentHeight
                                        },
                                        500
                                    );
                                    lastHeight = curHeight;
                                    firstAttempt = false;
                                }
                            },
                            500
                        );

                        $('.reviews-actions a').attr('target', '_parent');
                        $('.product-social-links a').attr('target', '_parent');
                        $(document).on(
                            'click',
                            'a',
                            function (e) {
                                e.preventDefault();
                                if ($(this).attr('data-post')) {
                                    qty = 0;
                                    from_key = '';
                                    data_url = jQuery.parseJSON($(this).attr('data-post'));
                                    if ($(this).parents('#maincontent').find('input[name="form_key"]').val() != '') {
                                        from_key = $(this).parents('#maincontent').find('input[name="form_key"]').val();
                                    }
                                    if ($(this).parents('#maincontent').find('input[name="qty"]').val() > 0) {
                                        qty = $(this).parents('#maincontent').find('input[name="qty"]').val();
                                    }
                                    url = data_url.action + 'product/' + data_url.data.product + '/qty/' + qty + '/form_key/' + from_key + '/uenc/' + data_url.data.uenc + '/bssquickview/1';
                                } else {
                                    url = $(this).attr('href');
                                    var myClass = $(this).attr('class');
                                }
                                if (showMoreInfo == 1 && showReview == 1) {
                                    if (url != '#additional' && url != '#reviews' && url != '#product.info.description' && myClass != 'action add' && url != '#description' && myClass != 'action view') {
                                        self.parent.location.href = url;
                                        return false;
                                    }
                                } else {
                                    if (url != '#additional' && url != '#reviews' && url != '#product.info.description' && url != '#description') {
                                        self.parent.location.href = url;
                                        return false;
                                    }
                                }
                            }
                        )
                    }
                );

                /** Events listener **/
                $(document).on(
                    'ajaxComplete',
                    function (event, xhr, settings) {
                        var parentBody = window.parent.document.body;
                        var cartMessage = false;
                        if (settings.type.match(/get/i) && _.isObject(xhr.responseJSON)) {
                            var result = xhr.responseJSON;
                            if (_.isObject(result.messages)) {
                                var messageLength = result.messages.messages.length;
                                var message = result.messages.messages[0];
                                if (messageLength && message.type == 'success') {
                                    cartMessage = message.text;
                                }
                            }
                            if (_.isObject(result.cart) && _.isObject(result.messages)) {
                                var messageLength = result.messages.messages.length;
                                var message = result.messages.messages[0];
                                if (messageLength && message.type == 'success') {
                                    cartMessage = message.text;
                                }
                            }
                        }
                    }
                );
            }
        }
    );
    return $.bss.bss_beforebodyend;
});
