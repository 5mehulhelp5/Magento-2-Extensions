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
 * @package    Magexperts_Quickview
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2022 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Quickview\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Add
 */
class SetRedirectUrlWhenAddCompareProduct
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Add constructor.
     *
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        Context                                              $context,
        StoreManagerInterface                                $storeManager,
        ProductRepositoryInterface                           $productRepository
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->context = $context;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * Redirect product detail page when add compare product
     *
     * @param $result
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws NoSuchEntityException
     */
    public function afterExecute($result){
        $resultRedirect = $this->redirectFactory->create();
        $productId = (int)$this->context->getRequest()->getParam('product');
        $storeId = $this->storeManager->getStore()->getId();
        try {
            $product = $this->productRepository->getById($productId, false, $storeId);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }
        if ($product)
        {
            return $resultRedirect->setUrl($product->getProductUrl());
        }
        return $result;
    }
}