<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\Rules;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magexperts\DeleteOrders\Model\RulesRepository;

/**
 * Class Delete
 *
 * Order delete rule
 */
class Delete extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::rules';

    /**
     * @var RulesRepository
     */
    protected $rulesRepository;

    /**
     * Restore constructor.
     *
     * @param Context $context
     * @param RulesRepository $rulesRepository
     */
    public function __construct(Context $context, RulesRepository $rulesRepository)
    {
        $this->rulesRepository = $rulesRepository;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $redirectResult = $this->resultRedirectFactory->create();
        if ($ruleId = $this->getRequest()->getParam("entity_id")) {
            try {
                $rule = $this->rulesRepository->get($ruleId);
                $this->rulesRepository->delete($rule);
                $this->messageManager->addSuccessMessage(__('Rule was successfully deleted'));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $redirectResult->setPath('deleteorders/rules');
        return $redirectResult;
    }
}
