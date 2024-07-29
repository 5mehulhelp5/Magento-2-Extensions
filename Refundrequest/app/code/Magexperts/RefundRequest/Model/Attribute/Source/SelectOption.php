<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\RefundRequest\Model\Attribute\Source;

class SelectOption implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Remind Status values
     */
    const ENABLE = 0;
    const DISABLE = 1;

    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ENABLE,  'label' => __('Enable')],
            ['value' => self::DISABLE,  'label' => __('Disable')]
        ];
    }
}
