/*global define*/
define(['jquery'], function ($) {
    'use strict';

    return function (Element) {
        return Element.extend({
            initialize: function () {
                this._super();
            },
            onReload: function (data) {
                this._super();

                // Apply amount display only if defined & enabled
                if (window.mpSalesOrderGridConfig !== undefined
                    && (window.mpSalesOrderGridConfig.is_active !== undefined
                        && window.mpSalesOrderGridConfig.is_active
                    )
                    && $('.sales-order-index #mp-sales-order-totals').length
                ) {
                    var items                   = data.items;
                    var totalAmount             = 0;
                    var baseCurrency            = window.mpSalesOrderGridConfig.base_currency_symbol;
                    var amountDisplayTemplate   = window.mpSalesOrderGridConfig.amount_display_text;
                    var enableRounding          = window.mpSalesOrderGridConfig.amount_display_rounding;
                    _.each(items, function (item) {
                        if (item['base_grand_total']) {
                            var baseGrandTotal = item['base_grand_total'].replace(baseCurrency, '');
                            totalAmount += parseFloat(baseGrandTotal);
                        }
                    });
                    if (totalAmount > 0) {
                        var fractionDigits = 2;
                        if (enableRounding == 1) {
                            fractionDigits = 0;
                        }
                        var formattedAmount = totalAmount.toFixed(fractionDigits).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                        formattedAmount = baseCurrency + formattedAmount;
                        var totalAmountDisplay = amountDisplayTemplate.replace('{{amount}}', formattedAmount);
                        $('.sales-order-index #mp-sales-order-totals-wrapper').show();
                        $('.sales-order-index #mp-sales-order-totals').html(totalAmountDisplay);
                    }
                }
            }
        });
    }
});
