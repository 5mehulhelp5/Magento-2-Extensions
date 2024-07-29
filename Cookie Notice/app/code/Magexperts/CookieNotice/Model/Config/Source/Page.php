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
 * @package    Magexperts_CookieNotice
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\CookieNotice\Model\Config\Source;

/**
 * CMS page collection
 */
class Page implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $res = [];
        $collection =  $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', \Magento\Cms\Model\Page::STATUS_ENABLED);
        foreach ($collection as $page) {
            $data['value'] = $page->getData('identifier');
            $data['label'] = $page->getData('title');
            if ($data['value'] != 'home') {
                $res[] = $data;
            }
        }
        return $res;
    }
}
