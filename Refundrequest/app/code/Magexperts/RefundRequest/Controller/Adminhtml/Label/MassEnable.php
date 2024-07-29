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
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\RefundRequest\Controller\Adminhtml\Label;

class MassEnable extends \Magento\Backend\App\Action
{
    /**
     * @var \Magexperts\RefundRequest\Helper\Data
     */
    protected $helper;
    /**
     * Mass Action Filter
     *
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Collection Factory
     *
     * @var \Magexperts\RefundRequest\Model\ResourceModel\Request\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * MassEnable constructor.
     * @param \Magexperts\RefundRequest\Helper\Data $helper
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magexperts\RefundRequest\Model\ResourceModel\Label\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magexperts\RefundRequest\Helper\Data $helper,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magexperts\RefundRequest\Model\ResourceModel\Label\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->helper = $helper;
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        if ($this->helper->getConfigEnableModule()):
            $setStatus = 0;
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            try {
                foreach ($collection as $item) {
                    if ($item["status"] !== 0) {
                        $this->setStatus($item);
                    }
                    $setStatus++;
                }
                $this->messageManager->addSuccessMessage(__('%1 option(s) enabled.', $setStatus));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        else:
            $this->messageManager->addWarningMessage(__('Module is disabled.'));
            return $resultRedirect->setPath('*/*/');
        endif;
    }

    /**
     * @param $item
     */
    protected function setStatus($item)
    {
        $item->setData('status', 0);
        $item->save();
    }

    /**
     * Check Rule
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization
            ->isAllowed("Magexperts_RefundRequest::refundrequest_access_controller_label_massenable");
    }
}
