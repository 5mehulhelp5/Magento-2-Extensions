<?php

namespace Magexperts\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use SimpleXMLElement;
use Zend\Http\Client\Adapter\Curl as CurlClient;
use Zend\Http\Response as HttpResponse;
use Zend\Uri\Http as HttpUri;
use Magento\Framework\Json\DecoderInterface;

class Extensions extends AbstractHelper
{
    const EXTENSIONS_PATH = 'magexperts_extensions';
    const URL_EXTENSIONS  = 'http://www.magexperts.com/shopfeed/index/extensiondata';

    /**
     * @var CurlClient
     */
    protected $curlClient;

    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cache;

    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    private $moduleReader;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $filesystem;

    /**
     * @var DecoderInterface
     */
    private $jsonDecoder;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $moduleList;

    /**
     * @var array
     */
    private $magexpertsExtensions = [];

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

    /**
     * @var array
     */
    private $moduleIgnoreList = ['Magexperts_Core', 'Magexperts_Tips'];

    /**
     * @var array
     */
    private $magexpertsPrefixList = ['Magexperts_', 'AdjustWare_'];

    /**
     * @var array
     */
    private $moduleDirs = ['Magexperts', 'AdjustWare'];

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\CacheInterface $cache,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem\Driver\File $filesystem,
        DecoderInterface $jsonDecoder,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        CurlClient $curl,
        \Magento\Framework\Module\ModuleListInterface $moduleList
    ) {
        parent::__construct($context);

        $this->cache = $cache;
        $this->curlClient = $curl;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
        $this->jsonDecoder = $jsonDecoder;
        $this->productMetadata = $productMetadata;
        $this->moduleList = $moduleList;
        $this->moduleManager = $context->getModuleManager();
    }

    /**
     * @return bool|mixed
     */
    public function getAllExtensions()
    {
        $data = $this->cache->load(self::EXTENSIONS_PATH);

        if (!$data) {
            $extensionsData = $this->getExtensionsPackagesData();
            $this->cache->save(json_encode($extensionsData), self::EXTENSIONS_PATH);
        }

        return json_decode($this->cache->load(self::EXTENSIONS_PATH), true);
    }

    /**
     * @param $version1
     * @param $version2
     * @param string $operator
     * @return mixed
     */
    public function compareExtensionComposerVersions($version1, $version2, $operator = '>')
    {
        return version_compare($version1, $version2, $operator);
    }

    /**
     * Save extensions data to magento cache
     */
    protected function getExtensionsPackagesData()
    {
        $resultData = [];
        $extensionsParsedJson = $this->getExtensionsData();

        if ($extensionsParsedJson && is_array($extensionsParsedJson)) {
            foreach ($extensionsParsedJson as $extName => $extData) {
                if ($extName && $extData) {
                    $resultData[$extName] = $extData;
                }
            }
        }

        return $resultData;
    }

    /**
     * Read data from xml file with curl
     * @return bool|SimpleXMLElement
     */
    protected function getExtensionsData()
    {
        $result = [];
        try {
            $extensionsData = file_get_contents(self::URL_EXTENSIONS);

            if ($extensionsData && is_string($extensionsData)) {
                $result = json_decode($extensionsData, true);
            }
        } catch (\Exception $e) {
            return false;
        }

        return $result;
    }


    /**
     * @param $extName
     * @return array|mixed
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getExtInfo($extName)
    {
        $dir = $this->moduleReader->getModuleDir('', $extName);

        if ($this->filesystem->isReadable($dir)) {
            return $this->readExtComposerFile($dir);
        }

        return [];
    }

    /**
     * @param $extDir
     * @return array|mixed
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function readExtComposerFile($extDir)
    {
        $file = $extDir . '/composer.json';

        if ($this->filesystem->isExists($file)) {
            $string = $this->filesystem->fileGetContents($file);

            return json_decode($string, true);
        }

        return [];
    }

    /**
     * @param bool $restrictedDelete
     * @return array
     */
    public function getMagexpertsExtensions($restrictedDelete = false)
    {
        if (!$this->magexpertsExtensions) {
            $modules = $this->moduleList->getNames();

            $dispatchResult = new \Magento\Framework\DataObject($modules);
            $modules = $dispatchResult->toArray();

            foreach ($this->magexpertsPrefixList as $prefix) {
                foreach ($modules as $item) {
                    if (strpos($item, $prefix) !== false) {
                        $this->magexpertsExtensions[] = $item;
                    }
                }
            }
        }

        if ($restrictedDelete) {
            foreach ($this->moduleIgnoreList as $value) {
                if (array_search($value, $this->magexpertsExtensions) !== false) {
                    unset($this->magexpertsExtensions[array_search($value, $this->magexpertsExtensions)]);
                }
            }
        }
        sort($this->magexpertsExtensions);

        return $this->magexpertsExtensions;
    }

    /**
     *
     * @param string $moduleName Fully-qualified module name
     * @return boolean
     */
    public function isModuleEnabled($moduleName)
    {
        return $this->_moduleManager->isEnabled($moduleName);
    }

    /**
     * @return string
     */
    public function getMagentoEdition()
    {
        return $this->productMetadata->getEdition();
    }

    /**
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }
}
