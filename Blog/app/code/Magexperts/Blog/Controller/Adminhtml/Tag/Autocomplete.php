<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Blog\Controller\Adminhtml\Tag;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Tag Ajax Autocomplete
 */
class Autocomplete extends \Magexperts\Blog\Controller\Adminhtml\Tag
{
    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $search = (string)$this->getRequest()->getParam('search');
        $collection = $this->_objectManager->create(\Magexperts\Blog\Model\Tag\AutocompleteData::class);

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson= $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($collection->getItems($search));
        return $resultJson;
    }
}
