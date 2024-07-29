<?php

namespace Magexperts\ProductAttachment\Block\Product\View;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magexperts\ProductAttachment\Model\AttachmentResolver;

/**
 * @category   Magexperts
 * @package    Magexperts_ProductAttachment
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Attachment extends Template
{
    const CACHE_TAG = 'Magexperts_productattachment_cache';
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var AttachmentResolver
     */
    private $attachmentResolver;

    public function __construct(
        Context $context,
        Registry $registry,
        AttachmentResolver $attachmentResolver,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->attachmentResolver = $attachmentResolver;
    }

    public function getAttachments()
    {
        return $this->attachmentResolver->getAttachments($this->getProduct());
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG];
    }
}
