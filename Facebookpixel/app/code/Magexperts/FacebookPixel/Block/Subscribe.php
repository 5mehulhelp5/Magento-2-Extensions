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
 * @category  Magexperts
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\FacebookPixel\Block;

use Magento\Customer\CustomerData\SectionSourceInterface;

class Subscribe implements SectionSourceInterface
{
    /**
     * @var \Magexperts\FacebookPixel\Model\SessionFactory
     */
    protected $fbPixelSession;

    /**
     * Subscribe constructor.
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     */
    public function __construct(
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
    ) {
        $this->fbPixelSession = $fbPixelSession;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData()
    {
        $data = [
            'events' => []
        ];

        if ($this->fbPixelSession->create()->hasAddSubscribe()) {
            $data['events'][] = [
                'eventName' => 'Subscribe',
                'eventAdditional' => $this->fbPixelSession->create()->getAddSubscribe()
            ];
        }
        return $data;
    }
}
