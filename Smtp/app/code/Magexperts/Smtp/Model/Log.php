<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model;

use Magexperts\Smtp\Api\Data\LogInterface;
use Magexperts\Smtp\Controller\RegistryConstants;

class Log extends \Magento\Framework\Model\AbstractModel implements LogInterface
{
    const LOG_ACTIVE = '1';
    const LOG_INACTIVE = '0';
    const LOG_ID_TYPE_FIELD = 'log_id';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var \Magexperts\Core\Model\Helpers\Date
     */
    private $date;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magexperts\Smtp\Model\ResourceModel\Log $resource,
        \Magexperts\Smtp\Model\ResourceModel\Log\Collection $resourceCollection,
        \Magexperts\Smtp\Model\Config $config,
        \Magexperts\Core\Model\Helpers\Date $date,
        array $data = []
    )
    {
        $this->config = $config;
        $this->date = $date;
        parent::__construct($context, $registry, $resource, $resourceCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_init(\Magexperts\Smtp\Model\ResourceModel\Log::class);
    }

    /**
     * @return int|mixed
     */
    public function getLogId()
    {
        return $this->getData(LogInterface::LOG_ID);
    }

    /**
     * @param int $logId
     * @return $this|LogInterface
     */
    public function setLogId($logId)
    {
        $this->setData(LogInterface::LOG_ID, $logId);

        return $this;
    }

    /**
     * @param $ruleId
     *
     * @return $this
     */
    public function getLogById($logId)
    {
        $resource = $this->getResource();
        $resource->load($this, $logId);

        return $this;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        parent::beforeSave();

        return $this->updateDate();
    }

    /**
     * @return $this
     */
    private function updateDate()
    {
        return $this;
    }

    /**
     * @param $message
     * @param array $errorData
     * @return $this
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function log($message, $errorData = [])
    {
        if ($this->config->logEnabled()) {
            $logData = $this->getLogData($message);
            $logData[LogInterface::CREATED_AT] = $this->date->getCurrentDate();
            $logData[LogInterface::STATUS] = $errorData ? $errorData[LogInterface::STATUS] : 0;
            $logData[LogInterface::STATUS_MESSAGE] = $errorData ? $errorData[LogInterface::STATUS_MESSAGE] : '';

            $this->setData($logData);
            $this->_resource->save($this);
        }

        return $this;
    }

    /**
     * @param $message
     * @return array
     */
    private function getLogData($message)
    {
        $result = [];

        if ($this->config->isNewSender(RegistryConstants::VERSION_COMPARISON_OLD_MAIL)) {
            $result[LogInterface::SUBJECT] = $message->getSubject() ?: '';
            $result[LogInterface::SENDER_EMAIL] = $this->getEmailsFromAddressList($message->getFrom());
            $result[LogInterface::RECIPIENT_EMAIL] = $this->getEmailsFromAddressList($message->getTo());
            $result[LogInterface::BCC] = $this->getEmailsFromAddressList($message->getBcc());
            $result[LogInterface::CC] = $this->getEmailsFromAddressList($message->getCc());
            $result[LogInterface::EMAIL_BODY] = htmlspecialchars($message->getBodyText());
        } else {
            $headers = $message->getHeaders();
            $result[LogInterface::SUBJECT] = isset($headers['Subject'][0]) ? $headers['Subject'][0] : '';
            $result[LogInterface::SENDER_EMAIL] = isset($headers['From'][0]) ? $headers['From'][0] : '';

            if (isset($headers['To'])) {
                $recipient = $headers['To'];
                if (isset($recipient['append'])) {
                    unset($recipient['append']);
                }

                $result[LogInterface::RECIPIENT_EMAIL] = $this->getEmailsFromAddressList($recipient);
            }

            if (isset($headers['Cc'])) {
                $cc = $headers['Cc'];
                if (isset($cc['append'])) {
                    unset($cc['append']);
                }

                $result[LogInterface::CC] = $this->getEmailsFromAddressList($cc);
            }

            if (isset($headers['Bcc'])) {
                $bcc = $headers['Bcc'];
                if (isset($bcc['append'])) {
                    unset($bcc['append']);
                }

                $result[LogInterface::BCC] = $this->getEmailsFromAddressList($bcc);
            }

            $emailBody = $message->getBodyHtml();

            if (is_object($emailBody)) {
                $result[LogInterface::EMAIL_BODY] = htmlspecialchars($emailBody->getRawContent());
            } else {
                $result[LogInterface::EMAIL_BODY] = htmlspecialchars($message->getBody()->getRawContent());
            }
        }

        return $result;
    }

    /**
     * @param $emails
     * @return string
     */
    private function getEmailsFromAddressList($emails)
    {
        $result = [];

        if (count($emails)) {
            foreach ($emails as $email) {
                $name = 'Unknown';

                if ($email->getName()) {
                    $name = $email->getName();
                }

                $result[] = "<" . $name . ">" . $email->getEmail();
            }
        }

        return implode(',', $result);
    }
}
