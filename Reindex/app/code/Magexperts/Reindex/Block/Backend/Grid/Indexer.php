<?php
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
 * @package    Magexperts_Reindex
 * @author     Extension Team
 * @copyright  Copyright (c) 2015-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\Reindex\Block\Backend\Grid;

/**
 * Class ItemsUpdater
 * @package Magexperts\Reindex\Block\Backend\Grid
 */
class Indexer extends \Magento\Framework\View\Element\Text
{
    /**
     * @var \Magexperts\Reindex\Helper\Data
     */
    private $helper;

    /**
     * Indexer constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magexperts\Reindex\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magexperts\Reindex\Helper\Data $helper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $script = "
        <script>
            var isCoreModuleEnabled = '{$this->helper->isCoreModuleEnabled()}';
            require(['jquery', 'domReady!'], function($) {
                'use strict';
                if (Boolean(isCoreModuleEnabled) !== true) {
                    $('#gridIndexer_massaction-select option[value=\"change_mode_reindex\"]').remove();
                }
                
                $('.bss-reindex-info').closest('.message-success.success').addClass('bss-hidden');
                $('.bss-reindex-show').click(function () {
                    if ($('.bss-reindex-info').length > 0) {
                        $('.bss-reindex-info').each(function () {
                            if ($(this).closest('.message-success.success').hasClass('bss-hidden')) {
                                $(this).closest('.message-success.success').removeClass('bss-hidden');
                            } else {
                                $(this).closest('.message-success.success').addClass('bss-hidden');
                            }
                        });
                    }
                });
            });
        </script>
        <style>
            .bss-hidden{
                display: none;
            }
        </style>";
        return $script;
    }

}
