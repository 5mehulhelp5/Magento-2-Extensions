<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\DataLayer;

use Magexperts\GoogleTagManager\Block\AbstractDataLayer;
use Magexperts\GoogleTagManager\Model\Config;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Context;
use Magexperts\GoogleTagManager\Api\DataLayer\ViewItemInterface;

class ViewItem extends AbstractDataLayer
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var ViewItemInterface
     */
    private $viewItem;

    /**
     * ViewItem constructor.
     *
     * @param Context $context
     * @param Config $config
     * @param Registry $registry
     * @param ViewItemInterface $viewItem
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $config,
        Registry $registry,
        ViewItemInterface $viewItem,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->viewItem = $viewItem;
        parent::__construct($context, $config, $data);
    }

    /**
     * Get GTM datalayer for product page
     *
     * @return array
     * @throws NoSuchEntityException
     */
    protected function getDataLayer(): array
    {
        return $this->viewItem->get($this->getCurrentProduct());
    }

    /**
     * Get current product
     *
     * @return Product
     */
    private function getCurrentProduct(): Product
    {
        return $this->registry->registry('current_product');
    }
}
