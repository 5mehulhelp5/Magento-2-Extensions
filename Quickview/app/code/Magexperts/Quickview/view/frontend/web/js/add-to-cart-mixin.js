define([
        'jquery',
        'mage/translate',
        'underscore',
        'Magento_Catalog/js/product/view/product-ids-resolver',
        'jquery-ui-modules/widget'
    ],
    function ($, $t, _, idsResolver) {
        'use strict';

        return function (catalogAddToCart) {
            $.widget('mage.catalogAddToCart', catalogAddToCart, {
                ajaxSubmit: function (form) {
                    var self = this,
                        productIds = idsResolver(form),
                        formData;
                    if ('context' in self.element){
                        var link = self.element.context.baseURI;
                    }

                    $(self.options.minicartSelector).trigger('contentLoading');
                    self.disableAddToCartButton(form);
                    formData = new FormData(form[0]);

                    $.ajax({
                        url: form.attr('action'),
                        data: formData,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,

                        /** @inheritdoc */
                        beforeSend: function () {
                            if (self.isLoaderEnabled()) {
                                $('body').trigger(self.options.processStart);
                            }
                        },

                        /** @inheritdoc */
                        success: function (res) {
                            var eventData, parameters;
                            $(document).trigger('ajax:addToCart', {
                                'sku': form.data().productSku,
                                'productIds': productIds,
                                'form': form,
                                'response': res
                            });

                            if (self.isLoaderEnabled()) {
                                $('body').trigger(self.options.processStop);
                            }

                            if (res.backUrl) {
                                eventData = {
                                    'form': form,
                                    'redirectParameters': []
                                };
                                // trigger global event, so other modules will be able add parameters to redirect url
                                $('body').trigger('catalogCategoryAddToCartRedirect', eventData);

                                if (eventData.redirectParameters.length > 0 &&
                                    window.location.href.split(/[?#]/)[0] === res.backUrl
                                ) {
                                    parameters = res.backUrl.split('#');
                                    parameters.push(eventData.redirectParameters.join('&'));
                                    res.backUrl = parameters.join('#');
                                }
                                if (link !== undefined) {
                                    res.backUrl = link;
                                }
                                else {
                                    res.backUrl = window.location.href.split(/[?#]/)[0];
                                }
                                self._redirect(res.backUrl);
                                return;
                            }

                            if (res.messages) {
                                $(self.options.messagesSelector).html(res.messages);
                            }

                            if (res.minicart) {
                                $(self.options.minicartSelector).replaceWith(res.minicart);
                                $(self.options.minicartSelector).trigger('contentUpdated');
                            }

                            if (res.product && res.product.statusText) {
                                $(self.options.productStatusSelector)
                                    .removeClass('available')
                                    .addClass('unavailable')
                                    .find('span')
                                    .html(res.product.statusText);
                            }
                            self.enableAddToCartButton(form);
                        },

                        /** @inheritdoc */
                        error: function (res) {
                            $(document).trigger('ajax:addToCart:error', {
                                'sku': form.data().productSku,
                                'productIds': productIds,
                                'form': form,
                                'response': res
                            });
                        },

                        /** @inheritdoc */
                        complete: function (res) {
                            if (res.state() === 'rejected') {
                                location.reload();
                            }
                        }
                    });
                }
            });

            return catalogAddToCart;
        };
    }
);
