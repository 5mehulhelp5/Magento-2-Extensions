<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Cli\Controller\Adminhtml\Index;

use Magexperts\Cli\Model\Config;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Magexperts_Cli::elements';

    protected $resultPageFactory;

    /**
     * @var Config
     */
    private $config;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param Config $config
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Config $config
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->config = $config;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $phpCommand = $this->config->getPhpCommand();

        if ($phpCommand && $this->config->isEnabled()) {
            $this->messageManager->addNoticeMessage(__('Commands will be executed by custom PHP binary: ')
                . $phpCommand);
        }

        return $this->resultPageFactory->create();
    }
}
