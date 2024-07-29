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
 * @package    Magexperts_StoreviewFlags
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\StoreviewFlags\Plugin;

/**
 * Class ShowFlagFrontend
 *
 * @package Magexperts\StoreviewFlags\Plugin
 */
class ShowFlagFrontend
{
    /**
     * @var \Magexperts\StoreviewFlags\Helper\Data
     */
    protected $helper;

    /**
     * ShowFlagFrontend constructor.
     *
     * @param \Magexperts\StoreviewFlags\Helper\Data $helper
     */
    public function __construct(
        \Magexperts\StoreviewFlags\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Plugin After
     *
     * @param \Magento\Store\Block\Switcher $subject
     * @param \Magento\Store\Block\Switcher $result
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetStores(\Magento\Store\Block\Switcher $subject, $result)
    {
        $data = [];
        if ($this->helper->getEndableModule()) {
            $storeIds = array_keys($result);
            foreach ($storeIds as $storeId) {
                if ($this->helper->getUrlImageFlag($storeId)) {
                    $data[$storeId] = [ 'width'  => $this->helper->getWidth($storeId),
                                        'height' => $this->helper->getHeight($storeId),
                                        'image'  => $this->helper->getUrlImageFlag($storeId),
                                        'show_label' => $this->helper->getShowStoreviewName($storeId)
                                        ];
                }
            }
        }
        $subject->setData('store_view_flag', $data);
        return $result;
    }
}
