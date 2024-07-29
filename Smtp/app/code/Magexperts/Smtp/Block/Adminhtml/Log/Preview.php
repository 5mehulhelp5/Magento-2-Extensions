<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Block\Adminhtml\Log;

use Magexperts\Smtp\Controller\RegistryConstants;

class Preview extends \Magento\Backend\Block\Widget
{
    const LOG_PARAM_URL_KEY = 'log_id';

    /**
     * @var \Magento\Framework\Filter\Input\MaliciousCode
     */
    protected $_maliciousCode;

    /**
     * @var \Magexperts\Smtp\Model\LogFactory
     */
    private $logFactory;

    /**
     * @var \Magexperts\Smtp\Model\Config
     */
    private $config;

    /**
     * @var string
     */
    protected $profilerName = 'email_template_proccessing';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Filter\Input\MaliciousCode $maliciousCode
     * @param \Magento\Email\Model\TemplateFactory $emailFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Filter\Input\MaliciousCode $maliciousCode,
        \Magexperts\Smtp\Model\LogFactory $logFactory,
        \Magexperts\Smtp\Model\Config $config,
        array $data = []
    ) {
        $this->logFactory = $logFactory;
        $this->_maliciousCode = $maliciousCode;
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed|string
     * @throws \Exception
     */
    protected function _toHtml()
    {
        $logModel = $this->getCurrentLog();
        $string = $logModel->getEmailBody();

        if ($this->config->isNewSender(RegistryConstants::VERSION_COMPARISON_NEW_MAIL)) {
            $string = quoted_printable_decode($string);
        }

        if ($logModel->getId()) {
            return  '<iframe onload="resizeIframe(this)" srcdoc="'. $string . '" style="width: 100%; height: 100%"></iframe>';
        } else {
            throw new \Exception('Log with ID not found. Pleas try again');
        }

        return $logModel;
    }

    /**
     * @return mixed
     */
    public function getCurrentLog()
    {
        return $this->logFactory->create()->getLogById($this->getRequest()->getParam(self::LOG_PARAM_URL_KEY));
    }

    /**
     * Get either default or any store view
     *
     * @return \Magento\Store\Model\Store|null
     */
    protected function getAnyStoreView()
    {
        $store = $this->_storeManager->getDefaultStoreView();
        if ($store) {
            return $store;
        }
        foreach ($this->_storeManager->getStores() as $store) {
            return $store;
        }
        return null;
    }
}
