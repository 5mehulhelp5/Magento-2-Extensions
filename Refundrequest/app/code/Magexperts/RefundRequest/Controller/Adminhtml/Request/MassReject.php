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
namespace Magexperts\RefundRequest\Controller\Adminhtml\Request;

/** * @SuppressWarnings(PHPMD.CouplingBetweenObjects) */
class MassReject extends \Magento\Backend\App\Action
{
    const STATUS_REJECT = 2;
    /**
     * @var \Magexperts\RefundRequest\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magexperts\RefundRequest\Helper\Email
     */
    protected $emailSender;

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
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @var \Magento\Framework\Locale\ListsInterface
     */
    protected $localeLists;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $writeAdapter;
    /**
     * @var \Magexperts\RefundRequest\Model\ResourceModel\Status
     */
    protected $statusResourceModel;

    /**
     * MassReject constructor.
     * @param \Magexperts\RefundRequest\Helper\Email $emailSender
     * @param \Magexperts\RefundRequest\Helper\Data $helper
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magexperts\RefundRequest\Model\ResourceModel\Request\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magento\Framework\Locale\ListsInterface $localeLists
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magexperts\RefundRequest\Model\ResourceModel\Status $statusResourceModel
     */
    public function __construct(
        \Magexperts\RefundRequest\Helper\Email $emailSender,
        \Magexperts\RefundRequest\Helper\Data $helper,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magexperts\RefundRequest\Model\ResourceModel\Request\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Framework\Locale\ListsInterface $localeLists,
        \Magento\Backend\App\Action\Context $context,
        \Magexperts\RefundRequest\Model\ResourceModel\Status $statusResourceModel
    ) {
        $this->helper = $helper;
        $this->emailSender = $emailSender;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->timezone = $timezone;
        $this->localeLists = $localeLists;
        $this->statusResourceModel = $statusResourceModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        if ($this->helper->getConfigEnableModule()) {
            $acceptOder = 0;
            $incrementIds = [];
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            try {
                foreach ($collection as $key => $item) {
                    if ($item["refund_status"] != 2) {
                        $this->sendEmail($item);
                        $incrementIds[$key] = $item["increment_id"];
                        $acceptOder++;
                    }
                }
                $this->statusResourceModel->updateOrderRefundStatus($incrementIds, self::STATUS_REJECT);
                $this->statusResourceModel->updateStatusAndTime($incrementIds, self::STATUS_REJECT);
                $this->messageManager->addSuccessMessage(__('%1 refund request has been rejected.', $acceptOder));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $this->messageManager->addWarningMessage(__('Module is disabled.'));
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $item
     */
    protected function sendEmail($item)
    {
        $customerEmail = $item->getCustomerEmail();
        $timezone = $this->scopeConfig->getValue('general/locale/timezone', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $date = $this->timezone->date();
        $timezoneLabel = $this->getTimezoneLabelByValue($timezone);
        $date = $date->format('Y-m-d h:i:s A') . " " . $timezoneLabel;
        $emailTemplate = $this->helper->getRejectEmailTemplate();
        $emailTemplateData = [
            'incrementId' => $item["increment_id"],
            'id' => $item["id"],
            'timeApproved'=> $date,
            'customerName' => $item["customer_name"]
        ];
        $this->emailSender->sendEmail($customerEmail, $emailTemplate, $emailTemplateData);
    }

    /**
     * @param $timezoneValue
     * @return string
     */
    protected function getTimezoneLabelByValue($timezoneValue)
    {
        $timezones = $this->localeLists->getOptionTimezones();
        $label = '';
        foreach ($timezones as $zone) {
            if ($zone["value"] == $timezoneValue) {
                $label = $zone["label"];
            }
        }
        return $label;
    }

    /**
     * Check Rule
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization
            ->isAllowed("Magexperts_RefundRequest::refundrequest_access_controller_request_massreject");
    }
}
