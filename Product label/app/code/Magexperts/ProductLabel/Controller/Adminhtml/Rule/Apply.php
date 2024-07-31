<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Controller\Adminhtml\Rule;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Apply
 */
class Apply extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magexperts_ProductLabel::rule';

    /**
     * @var \Magexperts\ProductLabel\Model\ProductLabelAction
     */
    protected $productLabelAction;

    /**
     * @var
     */
    protected $logger;

    /**
     * @var \Magexperts\ProductLabel\Api\RuleCollectionInterfaceFactory
     */
    protected $ruleCollection;

    /**
     * @var \Magexperts\ProductLabel\Model\Config
     */
    protected $config;

    /**
     * Apply constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magexperts\ProductLabel\Model\ProductLabelAction $productLabelAction
     * @param \Magexperts\ProductLabel\Api\RuleCollectionInterfaceFactory $ruleCollectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magexperts\ProductLabel\Model\ProductLabelAction $productLabelAction,
        \Magexperts\ProductLabel\Api\RuleCollectionInterfaceFactory $ruleCollectionFactory,
        \Magexperts\ProductLabel\Model\Config $config
    ) {
        $this->config = $config;
        $this->ruleCollection = $ruleCollectionFactory;
        $this->productLabelAction = $productLabelAction;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->getUrl('*/*/index'));

        try {
            $countRules = $this->ruleCollection->create()->getSize();

            if (!$countRules) {
                $this->messageManager->addError(__('Cannot find any rule.'));
            }

            if ($this->config->isEnabled()) {
                $this->productLabelAction->execute();
                $this->messageManager->addSuccess(__('Rules has been applied.'));
            } else {
                $this->messageManager->addNotice(__('Please enable the extension to apply rules.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Something went wrong. %1', $e->getMessage()));
        }

        return $resultRedirect;
    }
}
