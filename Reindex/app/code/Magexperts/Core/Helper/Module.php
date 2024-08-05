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

class Module
{
    /**
     * @var \Magexperts\Core\Helper\Data
     */
    private $magexpertsHelper;

    /**
     * @var \Magexperts\Core\Helper\Api
     */
    private $apiHelper;

    /**
     * @var array|null
     */
    private $modules = null;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $moduleList;

    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    private $dataObjectFactory;

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
     * Module constructor.
     * @param Data $magexpertsHelper
     * @param Api $apiHelper
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Framework\DataObjectFactory $dataObjectFactory
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem\Driver\File $filesystem
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     */
    public function __construct(
        Data $magexpertsHelper,
        Api $apiHelper,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\DataObjectFactory $dataObjectFactory,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem\Driver\File $filesystem,
        \Magento\Framework\Serialize\Serializer\Json $json
    )
    {
        $this->magexpertsHelper = $magexpertsHelper;
        $this->apiHelper = $apiHelper;
        $this->moduleList = $moduleList;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
        $this->json = $json;
    }

    /**
     * @return array
     */
    public function getModules()
    {
        if (!$this->modules) {
            $this->modules = $this->apiHelper->getModules();
        }
        if (!is_array($this->modules))
            return [];
        return $this->modules;
    }

    /**
     * Get magexperts.com module url.
     *
     * @param array $module
     * @return string
     */
    public function getModuleUrl($module)
    {
        return !empty($module['product_url']) ? $module['product_url'] : '#';
    }

    /**
     * Get Module User guide
     *
     * @param array $module
     * @return string
     */
    public function getModuleUserGuide($module)
    {
        if (!empty($module['user_guide'])) {
            $userGuide = $module['user_guide'];
            $userGuide = "<a href='$userGuide' target='_blank'>" . __('Link') . "</a>";
            return $userGuide;
        }
        return '';
    }

    /**
     * Get module latest version from magexperts.com.
     *
     * @param array $module
     * @param boolean $onlyVersionNumber If module has multi versions, Eg. CE_v1.0.99_for_M2.3.x, CE_v2.1.2_for_M2.3.x
     * Return only version number like 1.0.99, 2.1.2
     * @return string
     */
    public function getLatestVersion($module, $onlyVersionNumber = false)
    {
        $packages = $module['packages'];
        if (count($packages) == 1) {
            $moduleInfo = $packages[0];
            return $this->matchVersion($moduleInfo['title']);
        }

        $latestVer = $this->getLatestByExactVersionEdition($packages);
        if (empty($latestVer)) {
            $latestVer = $this->getLatestByExactEdition($packages);
        }

        if (empty($latestVer)) {
            $latestVer = $this->getLatestByExactVersion($packages);
        }
        if (empty($latestVer)) {
            $latestVer = $this->getLatestByRelativeVersion($packages);
        }

        if (empty($latestVer)) {
            if (is_array($packages) && isset($packages[0])) {
                $moduleInfo = $packages[0];
                return $this->matchVersion($moduleInfo['title']);
            }
            return 'unknown';
        }

        if ($onlyVersionNumber) {
            foreach ($latestVer as $key => $version) {
                $latestVer[$key] = $this->matchVersion($version);
            }
        }

        return max($latestVer);
    }

    /**
     * @param string $versionString
     * @return string
     */
    protected function matchVersion($versionString)
    {
        preg_match("/(?:v)((?:[0-9]+\.?)+)/i", $versionString, $matches);
        if (isset($matches[1]))
            return $matches[1];
        return '';
    }

    /**
     * Get module latest version by exact current Magento version and Edition.
     *
     * @param array $modulesInfo
     * @return array
     */
    protected function getLatestByExactVersionEdition($modulesInfo)
    {
        $magentoVer = $this->magexpertsHelper->getMagentoVersion();
        $curEdition = $this->magexpertsHelper->getMagentoEdition() == 'Community' ? 'CE' : 'EE';

        $latestVer = [];
        foreach ($modulesInfo as $moduleInfo) {
            $linkTitle = explode(" ", $moduleInfo['title']);
            $curlinkVer = ltrim($this->getLinkVersion($linkTitle), 'v');

            if (strpos($curlinkVer, $magentoVer) !== false && strpos($curlinkVer, $curEdition) !== false) {
                $latestVer[] = $curlinkVer;
            }
        }

        return $latestVer;
    }

    /**
     * Get module latest version by exact current Magento Edition.
     *
     * @param array $modulesInfo
     * @return array
     */
    protected function getLatestByExactEdition($modulesInfo)
    {
        $magentoRelativeVer = $this->magexpertsHelper->getMagentoRelativeVersion();
        $curEdition = $this->magexpertsHelper->getMagentoEdition() == 'Community' ? 'CE' : 'EE';

        $latestVer = [];
        foreach ($modulesInfo as $moduleInfo) {
            $linkTitle = explode(" ", $moduleInfo['title']);
            $curlinkVer = ltrim($this->getLinkVersion($linkTitle), 'v');

            if (strpos($curlinkVer, $magentoRelativeVer) !== false
                && strpos($curlinkVer, $curEdition) !== false) {
                $latestVer[] = $curlinkVer;
            }
        }

        return $latestVer;
    }

    /**
     * Get module latest version by exact current Magento Version.
     *
     * @param array $modulesInfo
     * @return array
     */
    protected function getLatestByExactVersion($modulesInfo)
    {
        $magentoVer = $this->magexpertsHelper->getMagentoVersion();

        $latestVer = [];
        foreach ($modulesInfo as $moduleInfo) {
            $linkTitle = explode(" ", $moduleInfo['title']);
            $curlinkVer = ltrim($this->getLinkVersion($linkTitle), 'v');

            if (strpos($curlinkVer, $magentoVer) !== false) {
                $latestVer[] = $curlinkVer;
            }
        }

        return $latestVer;
    }

    /**
     * Get module latest version by current Magento Relative Version.
     *
     * @param array $modulesInfo
     * @return array
     */
    protected function getLatestByRelativeVersion($modulesInfo)
    {
        $magentoRelativeVer = $this->magexpertsHelper->getMagentoRelativeVersion();
        $latestVer = [];
        foreach ($modulesInfo as $moduleInfo) {
            $linkTitle = explode(" ", $moduleInfo['title']);
            $curlinkVer = ltrim($this->getLinkVersion($linkTitle), 'v');

            if (strpos($curlinkVer, $magentoRelativeVer) !== false) {
                $latestVer[] = $curlinkVer;
            }
        }

        return $latestVer;
    }

    /**
     * Get version from link title.
     *
     * @param array $linkTitle
     * @return string
     */
    protected function getLinkVersion($linkTitle)
    {
        $index = (count($linkTitle) - 1);
        return $linkTitle[$index];
    }

    /**
     * @param string $apiName
     * @return array
     */
    public function searchByModule($apiName)
    {
        $modules = $this->getModules();
        $indexOfModule = array_search($apiName, array_column($modules, 'name'));
        if ($indexOfModule !== false) {
            return $modules[$indexOfModule];
        }
        return [];
    }

    /**
     * @return array
     */
    public function getLocalMagexpertsModules()
    {
        $modules = $this->moduleList->getNames();

        $dispatchResult = $this->dataObjectFactory->create()->setData($modules);
        $modules = $dispatchResult->toArray();

        sort($modules);
        $result = [];
        foreach ($modules as $moduleName) {
            if (strstr($moduleName, 'Magexperts_') === false
                || $moduleName === 'Magexperts_Core'
            ) {
                continue;
            }
            $result[] = $moduleName;
        }

        return $result;
    }

    /**
     * Get installed module info by composer.json.
     *
     * @param string $moduleCode
     * @return array|bool|float|int|mixed|string|null
     */
    public function getLocalModuleInfo($moduleCode)
    {
        try {
            $dir = $this->moduleReader->getModuleDir('', $moduleCode);
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
     * @return array
     */
    public function getListNewModuleVersion()
    {
        $localModules = $this->getLocalMagexpertsModules();
        $result = [];
        foreach ($localModules as $moduleName) {
            $localModule = $this->getLocalModuleInfo($moduleName);
            if (!empty($localModule) && isset($localModule['name'])) {
                $remoteModule = $this->searchByModule($localModule['name']);

                if (!empty($remoteModule)) {
                    $localModuleVersion = isset($localModule['extra']['suite-version']) ?
                        $localModule['extra']['suite-version'] : $localModule['version'];
                    $latestVer = $this->getLatestVersion($remoteModule, true);
                    $moduleLink = $this->getModuleUrl($remoteModule);
                    $moduleLink .= $moduleLink == '#' ? '' : '#release-note';
                    if (version_compare($latestVer, $localModuleVersion) > 0) {
                        $result[] = [
                            'name' => $remoteModule['product_name'],
                            'current_version' => $localModuleVersion,
                            'latest_version' => $latestVer,
                            'release_note' => $moduleLink
                        ];
                    }
                }
            }
        }

        return $result;
    }
}
