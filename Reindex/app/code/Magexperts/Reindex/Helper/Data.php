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

namespace Magexperts\Reindex\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 * @package Magexperts\Core\Helper
 */
class Data extends AbstractHelper
{
    const MAGEXPERTS_CORE_MODULE_NAME = 'Magexperts_Core';
    const MAGEXPERTS_GRAPHQL_ENDPOINT = 'https://magexperts.com/graphql';

    /**
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

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
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem\Driver\File $filesystem
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem\Driver\File $filesystem,
        \Magento\Framework\Serialize\Serializer\Json $json
    )
    {
        parent::__construct($context);
        $this->moduleManager = $moduleManager;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
        $this->json = $json;
    }

    /**
     * @return bool
     */
    public function isCoreModuleEnabled()
    {
        return $this->moduleManager->isEnabled(self::MAGEXPERTS_CORE_MODULE_NAME);
    }

    /**
     * @return array|mixed|string
     */
    public function getModuleName()
    {
        $localModule = $this->getLocalModuleInfo();

        if (empty($localModule)) {
            return '';
        }

        $suite = null;
        if (isset($localModule['extra']['suite'])) {
            $suite = $localModule['extra']['suite'];
        }

        if ($this->moduleManager->isEnabled('Magexperts_Breadcrumbs') && $suite == 'seo-suite') {
            return '';
        }

        $packageName = $localModule['description'];
        $apiName = $localModule['name'];

        $remoteModuleInfo = $this->getMagexpertsModuleInfo($apiName);

        if (!empty($remoteModuleInfo) && isset($remoteModuleInfo['data']['module']['product_name']))
            $moduleName = $remoteModuleInfo['data']['module']['product_name'];

        if (empty($moduleName))
            $moduleName = $packageName;

        return $moduleName;
    }

    /**
     * Get installed module info by composer.json.
     *
     * @return array|bool|float|int|mixed|string|null
     */
    public function getLocalModuleInfo()
    {
        try {
            $dir = $this->moduleReader->getModuleDir('', $this->_getModuleName());
            $file = $dir . '/composer.json';

            $string = $this->filesystem->fileGetContents($file);
            $result = $this->json->unserialize($string);

            if (!is_array($result)
                || !array_key_exists('version', $result)
                || !array_key_exists('description', $result)
            ) {
                return '';
            }

            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @param string $apiName
     * @return array
     */
    protected function getMagexpertsModuleInfo(string $apiName): array
    {
        $headers = ['Content-Type: application/json'];
        $query = "
        query {
            module (api_name: \"$apiName\") {
                product_name
                product_url
            }
	    }";
        try {
            if (false === $data = file_get_contents(self::MAGEXPERTS_GRAPHQL_ENDPOINT, false, stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => $headers,
                        'content' => $this->json->serialize(['query' => $query]),
                    ]
                ]))) {
                $error = error_get_last();
                throw new \ErrorException($error['message'], $error['type']);
            }

            return $this->json->unserialize($data);
        } catch (\ErrorException $exception) {
            $this->_logger->critical($exception->getMessage());
            return [];
        } catch (\Exception $exception) {
            $this->_logger->critical($exception->getMessage());
            return [];
        }
    }
}
