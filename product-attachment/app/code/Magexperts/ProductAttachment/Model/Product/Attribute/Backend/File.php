<?php

namespace Magexperts\ProductAttachment\Model\Product\Attribute\Backend;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Psr\Log\LoggerInterface;
use Magexperts\ProductAttachment\Model\Config;

/**
 * @category   Magexperts
 * @package    Magexperts_ProductAttachment
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class File extends AbstractBackend
{
    /**
     * @var Filesystem\Driver\File
     */
    protected $_file;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * @var UploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        LoggerInterface $logger,
        Filesystem $filesystem,
        Filesystem\Driver\File $file,
        UploaderFactory $fileUploaderFactory,
        Config $config
    ) {
        $this->_file = $file;
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_logger = $logger;
        $this->config = $config;
    }

    public function afterSave($object)
    {
        $path = $this->_filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(
            'catalog/product/attachment/'
        );
        $delete = $object->getData($this->getAttribute()->getName() . '_delete');

        if ($delete) {
            $fileName = $object->getData($this->getAttribute()->getName());
            $object->setData($this->getAttribute()->getName(), '');
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
            if ($this->_file->isExists($path . $fileName)) {
                $this->_file->deleteFile($path . $fileName);
            }
        }

        if (empty($_FILES['product']['tmp_name'][$this->getAttribute()->getName()])) {
            return $this;
        }

        try {
            /** @var $uploader Uploader */
            $uploader = $this->_fileUploaderFactory->create([
                'fileId' => 'product[' . $this->getAttribute()->getName() . ']'
            ]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowedExtensions($this->config->getAttachmentAllowedExtensions());
            $result = $uploader->save($path);
            $object->setData($this->getAttribute()->getName(), $result['file']);
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
        } catch (\Exception $e) {
            if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                $this->_logger->critical($e);
            }
        }

        return $this;
    }
}
