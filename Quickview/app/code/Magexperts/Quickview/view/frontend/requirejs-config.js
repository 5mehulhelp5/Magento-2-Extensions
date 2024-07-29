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
var config = {
    map: {
        '*': {
            bss_config: 'Magexperts_Quickview/js/bss_config',
            magnificPopup: 'Magexperts_Quickview/js/jquery.magnific-popup.min',
            bss_tocart: 'Magexperts_Quickview/js/bss_tocart'
        }
    },
    shim: {
        magnificPopup: {
            deps: ['jquery']
        }
    },
    config : {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Magexperts_Quickview/js/add-to-cart-mixin': true
            }
        }
    }
};
