define([
    'underscore',
    'Magento_Ui/js/grid/columns/select',
], function(_, Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: window.mpSalesOrderGridConfig !== undefined
                && (window.mpSalesOrderGridConfig.is_active !== undefined
                    && window.mpSalesOrderGridConfig.is_active
                ) ? 'Magexperts_SalesOrderGrid/ui/grid/cells/status' : 'ui/grid/cells/text'
        },
        getStatusTextColor(hexCode) {
            if (hexCode == 'transparent') {
                return '#303030';
            }
            return this._shouldTextBeBlack(hexCode) ? '#303030' : '#ffffff';
        },
        _shouldTextBeBlack(backgroundColor) {
            return this._computeBrightness(backgroundColor) > 0.179;
        },
        _computeBrightness(backgroundColor) {
            var colors = this._hexToRgb(backgroundColor);
            var components = ['r', 'g', 'b'];
            for (var i in components) {
                var c = components[i];
                colors[c] = colors[c] / 255.0;
                if (colors[c] <= 0.03928) {
                    colors[c] = colors[c] / 12.92;
                } else {
                    colors[c] = Math.pow(((colors[c] + 0.055) / 1.055), 2.4);
                }
            }
            return 0.2126 * colors.r + 0.7152 * colors.g + 0.0722 * colors.b;
        },
        _hexToRgb(hexCode) {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hexCode);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16),
            } : null;
        }
    });
});
