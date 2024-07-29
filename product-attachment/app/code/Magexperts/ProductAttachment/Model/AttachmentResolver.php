<?php

namespace Magexperts\ProductAttachment\Model;

use Magento\Catalog\Model\Product;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @category   Magexperts
 * @package    Magexperts_ProductAttachment
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AttachmentResolver
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var File
     */
    private $file;

    public function __construct(
        StoreManagerInterface $storeManager,
        File $file
    ) {
        $this->storeManager = $storeManager;
        $this->file = $file;
    }

    public function getAttachments(Product $product)
    {
        $attachments = [];
        if ($this->isValidFile($product->getData('mp_attachment_file'))) {
            $attachments[] = $this->prepareAttachment(
                $product->getData('mp_attachment_label'),
                $product->getData('mp_attachment_file')
            );
        }
        return $attachments;
    }

    private function prepareAttachment($label, $file)
    {
        return [
            'label' => $this->getAttachmentLabel($label),
            'link' => $this->getAttachmentUrl($file)
        ];
    }

    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    public function isValidFile($file)
    {
        if (!strlen($file)) {
            return false;
        }
        return $this->file->isFile($this->getAttachmentPath($file));
    }

    public function getAttachmentPath($file)
    {
        return $this->storeManager->getStore()
                ->getBaseMediaDir(). '/catalog/product/attachment' . $file;
    }

    public function getAttachmentUrl($file)
    {
        return $this->getMediaUrl() . 'catalog/product/attachment' . $file;
    }

    public function getAttachmentLabel($label)
    {
        return $label ?? 'Download';
    }
}
