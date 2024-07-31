/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

define([
    'Magexperts_Blog/js/components/new-tag'
], function (Select) {
    'use strict';

    return Select.extend({

        /**
         * Normalize option object.
         *
         * @param {Object} data - Option object.
         * @returns {Object}
         */
        parseData: function (data) {
            return {
                'is_active': data.model['is_active'],
                level: data.model['level'],
                value: data.model['category_id'],
                label: data.model['title'],
                parent: data.model['parent_id']
            };
        }
    });
});
