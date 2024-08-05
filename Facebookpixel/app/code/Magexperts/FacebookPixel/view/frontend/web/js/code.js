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
    'jquery'
], function ($) {
    "use strict";
    return function (config) {
        var id = config.id;
        var action = config.action;
        var productData = config.productData;
        var categoryData = config.categoryData;
        var registration = config.registration;
        var addToWishList = config.addToWishList;
        var initiateCheckout = config.initiateCheckout;
        var search = config.search;
        var orderData = config.orderData;
        var pageView = config.pageView;


        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];
            t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');

        window.fb = function() {
            if (registration.email) {
                fbq('init', id, {
                    em : registration.email,
                    fn : registration.fn,
                    ln : registration.ln,
                });
            } else if (orderData.content_ids) {
                fbq('init', id, {
                    em : orderData.email,
                    ph : orderData.phone,
                    fn : orderData.firtname,
                    ln : orderData.lastname,
                    ct : orderData.city,
                    st : orderData.st,
                    country : orderData.country,
                    zp : orderData.zipcode
                });
            } else if ($('.magexperts-subscribe-email').text()) {
                fbq('init', id, {
                    em : $('.magexperts-subscribe-email').text()
                });
            } else {
                fbq('init', id);
            }

            if ($('.magexperts-subscribe-email').text()) {
                fbq('track', 'Subscribe', {
                    id : $('.magexperts-subscribe-id').text()
                });

                $('.magexperts-subscribe-id').text('');
                $('.magexperts-subscribe-email').text('');
            }

            if (action == 'checkout_index_index' && pageView != 'pass') {
                fbq.disablePushState = true;
            }

            if (pageView == 'pass') {
                fbq('track', 'PageView');
            }

            if (action == 'catalog_product_view' && productData != 404) {
                fbq('track', 'ViewContent', {
                    content_name: productData.content_name ,
                    content_ids: productData.content_ids,
                    content_type: 'product',
                    value: productData.value,
                    currency: productData.currency
                });
            }

            if (action == 'catalog_category_view' && categoryData != 404) {
                fbq('trackCustom', 'ViewCategory', {
                    content_name: categoryData.content_name,
                    content_ids: categoryData.content_ids,
                    content_type: 'product_group',
                    currency: categoryData.currency
                });
            }

            if (addToWishList != 404) {
                fbq('track', 'AddToWishlist', {
                    content_type : 'product',
                    content_ids : addToWishList.content_ids,
                    content_name : addToWishList.content_name,
                    currency : addToWishList.currency
                });
            }

            if (search != 404) {
                fbq('track', 'Search', {
                    search_string : search.search_string
                });
            }

            if (initiateCheckout != 404) {
                fbq('track', 'InitiateCheckout', {
                    content_ids: initiateCheckout.content_ids,
                    content_type: 'product',
                    contents: initiateCheckout.contents,
                    value: initiateCheckout.value,
                    currency: initiateCheckout.currency
                });
            }

            if (orderData != 404) {
                fbq('track', 'Purchase', {
                    content_ids: orderData.content_ids,
                    content_type: 'product',
                    contents: orderData.contents,
                    value: orderData.value,
                    num_items : orderData.num_items,
                    currency: orderData.currency
                });
            }

            if (registration != 404) {
                fbq('track', 'CompleteRegistration', {
                    customer_id: registration.customer_id
                });
            }
        };
        return window.fb();
    }
});
