<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\Rules;

use Magento\Backend\App\Action;

/**
 * Class NewAction
 *
 * New rule
 */
class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::rules';

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
