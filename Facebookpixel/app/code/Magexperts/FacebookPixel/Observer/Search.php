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
 * @category  Magexperts
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\FacebookPixel\Observer;

use Magento\Framework\Event\ObserverInterface;

class Search implements ObserverInterface
{
    /**
     * @var \Magexperts\FacebookPixel\Model\SessionFactory
     */
    protected $fbPixelSession;
    /**
     * @var \Magexperts\FacebookPixel\Helper\Data
     */
    protected $fbPixelHelper;
    /**
     * @var \Magento\Search\Helper\Data
     */
    protected $searchHelper;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * Search constructor.
     * @param \Magexperts\FacebookPixel\Helper\Data $helper
     * @param \Magento\Search\Helper\Data $searchHelper
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     */
    public function __construct(
        \Magexperts\FacebookPixel\Helper\Data $helper,
        \Magento\Search\Helper\Data $searchHelper,
        \Magento\Framework\App\RequestInterface $request,
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
    ) {
        $this->fbPixelSession = $fbPixelSession;
        $this->fbPixelHelper         = $helper;
        $this->searchHelper = $searchHelper;
        $this->request = $request;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return boolean
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $text = $this->searchHelper->getEscapedQueryText();
        if (!$text) {
            $text = $this->request->getParams();
            foreach ($this->request->getParams() as $key => $value) {
                $text[$key] = $value;
            }
        }
        if (!$this->fbPixelHelper->isSearch() || !$text) {
            return true;
        }

        $data = [
            'search_string' => $text
        ];
        $this->fbPixelSession->create()->setSearch($data);

        return true;
    }
}
