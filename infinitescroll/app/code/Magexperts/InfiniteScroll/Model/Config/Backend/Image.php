<?php
/**
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future. If you wish to customize the module for your
 * needs please contact us to https://www.magexperts.com/contact-us.html
 *
 * @category    Ecommerce
 * @package     Magexperts_InfiniteScroll
 * @copyright   Copyright (c) 2019 Magexperts Technologies Pvt. Ltd. All Rights Reserved.
 * @url         https://www.magexperts.com/magento2-extensions/partial-payment-m2.html
 *
 **/
namespace Magexperts\InfiniteScroll\Model\Config\Backend;

class Image extends \Magento\Config\Model\Config\Backend\Image
{
    /**
     * The tail part of directory path for uploading
     */
    const UPLOAD_DIR = 'magexperts/infinitescroll';

    /**
     * Upload max file size in kilobytes
     *
     * @var int
     */
    protected $_maxFileSize = 20480;

    /**
     * Return path to directory for upload file
     *
     * @return string
     * @throw \Magento\Framework\Exception\LocalizedException
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    /**
     * Makes a decision about whether to add info about the scope.
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }

    /**
     * Getter for allowed extensions of uploaded files.
     *
     * @return string[]
     */
    protected function getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }

    /**
     * @return string|null
     */
    protected function getTmpFileName()
    {
        $tmpName = null;
        if (isset($_FILES['groups'])) {
            $tmpName = $_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value'];
        } else {
            $tmpName = is_array($this->getValue()) ? $this->getValue()['tmp_name'] : null;
        }
        return $tmpName;
    }

    /**
     * Save uploaded file before saving config value
     *
     * Save changes and delete file if "delete" option passed
     *
     * @return $this
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        $deleteFlag = is_array($value) && !empty($value['delete']);
        $fileTmpName = $this->getTmpFileName();

        if ($this->getOldValue() && ($fileTmpName || $deleteFlag)) {
            $this->_mediaDirectory->delete(self::UPLOAD_DIR . '/' . $this->getOldValue());
        }
        return parent::beforeSave();
    }
}