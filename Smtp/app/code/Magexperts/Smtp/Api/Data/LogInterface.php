<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Api\Data;

/**
 * Interface LogInterface
 * @package Magexperts\Smtp\Api\Data
 */
interface LogInterface
{
    /**
     * Constants
     */
    const TABLE_NAME = 'magexperts_smtp_log';

    const LOG_ID = 'log_id';
    const CREATED_AT = 'created_at';
    const SUBJECT = 'subject';
    const EMAIL_BODY = 'email_body';
    const SENDER_EMAIL = 'sender_email';
    const RECIPIENT_EMAIL = 'recipient_email';
    const CC = 'cc';
    const BCC = 'bcc';
    const STATUS = 'status';
    const STATUS_MESSAGE = 'status_message';

    /**
     * @return int
     */
    public function getLogId();

    /**
     * @param int $logId
     * @return LogInterface
     */
    public function setLogId($logId);
}
