<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Model\Helpers;

class Date
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    private $dateTime;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $date;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timezone;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->dateTime = $dateTime;
        $this->date = $date;
        $this->timezone = $timezone;
    }

    /**
     * @param bool $includedTime
     *
     * @return null|string
     */
    public function getCurrentDate($includedTime = true)
    {
        return $this->dateTime->formatDate($this->date->gmtTimestamp(), $includedTime);
    }

    /**
     * @param      $stringTime
     * @param bool $includedTime
     *
     * @return null|string
     */
    public function getDateFromString($stringTime, $includedTime = true)
    {
        return $this->dateTime->formatDate($this->dateTime->strToTime($stringTime), $includedTime);
    }

    /**
     * @param $stringTime
     *
     * @return int
     */
    public function getTimestampFromString($stringTime)
    {
        return $this->dateTime->strToTime($stringTime);
    }

    /**
     * @param      $days
     * @param bool $seconds
     *
     * @return int|null|string
     */
    public function getCurrentDateAfterDays($days, $seconds = false)
    {
        $timestamp = $this->date->gmtTimestamp() + ($days * 24 * 3600);

        return $seconds ? $timestamp : $this->dateTime->formatDate($timestamp);
    }

    /**
     * @param      $days
     * @param bool $seconds
     *
     * @return int|null|string
     */
    public function getCurrentDateBeforeDays($days, $seconds = false)
    {
        $timestamp = $this->date->gmtTimestamp() - ($days * 24 * 3600);

        return $seconds ? $timestamp : $this->dateTime->formatDate($timestamp);
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->date->gmtTimestamp();
    }

    /**
     * @return string
     */
    public function getTimezoneDate()
    {
        return $this->timezone->formatDate(null, \IntlDateFormatter::SHORT, true);
    }
}
