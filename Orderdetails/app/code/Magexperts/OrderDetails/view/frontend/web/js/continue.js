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
 * =================================================================
 *
 * MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Magexperts does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magexperts does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   Magexperts
 * @package    Magexperts_OrderDetails
 * @author     Extension Team
 * @copyright  Copyright (c) 2015-2016 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
define([
        "jquery",
    ], function ($) {
        $(document).ready(function ($) {
            $(".actions-toolbar").addClass('button-continue');
            $(".button-continue").removeClass('actions-toolbar');
        });
    });