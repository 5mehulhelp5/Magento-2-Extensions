<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Controller\Adminhtml\Smtp;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Email\Model\Template\SenderResolver;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magexperts\Smtp\Controller\RegistryConstants;

class Test extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magexperts_Smtp::main';
    const TEST_EMAIL_TO_FIELD_NAME = 'test_email_to';

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var TransportBuilder
     */
    private $_transportBuilder;

    /**
     * @var SenderResolver
     */
    private $senderResolver;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    private $jsonEncoder;

    /**
     * @var Factory
     */
    private $configFactory;

    /**
     * @var \Magexperts\Smtp\Model\Config
     */
    private $config;

    /**
     * @var \Magento\Framework\Mail\TransportInterfaceFactory
     */
    private $transportInterfaceFactory;

    public function __construct(
        Context $context,
        LoggerInterface $logger,
        SenderResolver $senderResolver,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Config\Model\Config\Factory $configFactory,
        \Magexperts\Smtp\Model\Config $config,
        \Magento\Framework\Mail\TransportInterfaceFactory $transportInterfaceFactory
    ) {
        $this->logger = $logger;
        $this->transportInterfaceFactory = $transportInterfaceFactory;
        $this->senderResolver = $senderResolver;
        $this->jsonEncoder = $jsonEncoder;
        $this->configFactory = $configFactory;
        $this->config = $config;

        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();

        try {
            if ($data && isset($data[self::TEST_EMAIL_TO_FIELD_NAME])) {
                $config = $this->config->convertFromPostToSmtpParams($this->removeUnusedFields($data));
                $config[RegistryConstants::IS_TEST_FIELD_ARRAY] = true;
                unset($config[self::TEST_EMAIL_TO_FIELD_NAME]);

                $transport = $this->transportInterfaceFactory->create($config);


                $transport->testSend($data[self::TEST_EMAIL_TO_FIELD_NAME]);

                $result = [
                    'status' => true,
                    'content' => __('Message is successfully send!')
                ];
            } else {
                $result = [
                    'status' => false,
                    'content' => __('Error. Something went wrong. Please, try again.')
                ];
            }
        } catch (LocalizedException $exception) {
            $result = [
                'status' => false,
                'content' => $exception->getMessage()
            ];
        } catch (\Exception $exception) {
            $result = [
                'status' => false,
                'content' => $exception->getMessage()
            ];
        }

        return $this->getResponse()->representJson($this->jsonEncoder->encode($result));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function removeUnusedFields($data)
    {
        $fields = ['key', 'section', 'isAjax', 'form_key'];

        foreach ($fields as $field) {
            if (isset($data[$field]) && $data[$field]) {
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_Smtp::main');
    }
}
