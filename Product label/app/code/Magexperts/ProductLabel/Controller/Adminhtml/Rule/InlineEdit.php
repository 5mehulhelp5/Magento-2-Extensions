<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Controller\Adminhtml\Rule;

use Magento\Framework\Controller\Result\Json;

/**
 * Class InlineEdit
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magexperts_ProductLabel::rule';

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * InlineEdit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $ruleItems = $this->getRequest()->getParam('items', []);
            if (!count($ruleItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($ruleItems) as $modelid) {
                    /** @var \Magento\Cms\Model\Block $block */
                    $model = $this->_objectManager->create(\Magexperts\ProductLabel\Model\Rule::class)->load($modelid);
                    try {
                        $model->setData(array_merge($model->getData(), $ruleItems[$modelid]));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Rule ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
