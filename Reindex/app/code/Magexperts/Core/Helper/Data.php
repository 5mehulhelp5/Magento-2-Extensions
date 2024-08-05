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
 * @package    Magexperts_Core
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    private $moduleReader;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $filesystem;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $json;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem\Driver\File $filesystem
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem\Driver\File $filesystem,
        \Magento\Framework\Serialize\Serializer\Json $json
    )
    {
        parent::__construct($context);
        $this->productMetadata = $productMetadata;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
        $this->json = $json;
    }

    /**
     * Get Store config values
     *
     * @param string $path
     * @return mixed
     */
    public function getStoreConfig($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return boolean
     */
    public function isEnablePopup()
    {
        return $this->getStoreConfig('magexperts_core/setting/enable_popup');
    }

    /**
     * @return String
     */
    public function getCustomCss()
    {
        return $this->getStoreConfig('magexperts_core/setting/additional_css');
    }

    /**
     * @return boolean
     */
    public function isEnablePreprocessedCss()
    {
        return $this->getStoreConfig('magexperts_core/setting/enable_preprocessed_css');
    }

    /**
     * Get current Magento version.
     *
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * Get current Magento relative version.
     *
     * @return string
     */
    public function getMagentoRelativeVersion()
    {
        $magentoVer = $this->getMagentoVersion();
        $relativeVerTemp = explode('.', $magentoVer);

        if (empty($relativeVerTemp)) {
            return '';
        }

        unset($relativeVerTemp[count($relativeVerTemp) - 1]);
        $relativeVerTemp[] = 'x';
        $relativeVer = implode('.', $relativeVerTemp);

        return $relativeVer;
    }

    /**
     * Get current Magento Edition.
     *
     * @return string
     */
    public function getMagentoEdition()
    {
        return $this->productMetadata->getEdition();
    }

    /**
     * Is module enabled?
     *
     * @param string $moduleName
     * @return bool
     */
    public function isModuleEnable($moduleName)
    {
        return $this->_moduleManager->isEnabled($moduleName);
    }
}
