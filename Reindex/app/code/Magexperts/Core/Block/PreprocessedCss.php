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

namespace Magexperts\Core\Block;

class PreprocessedCss extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepository;

    /**
     * @var \Magexperts\Core\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $moduleList;

    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    private $moduleReader;

    /**
     * PreprocessedCss constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magexperts\Core\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magexperts\Core\Helper\Data $helper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
        $this->assetRepository = $context->getAssetRepository();
        $this->moduleReader = $moduleReader;
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getAssetCssFiles()
    {
        if (!$this->helper->isEnablePreprocessedCss()) {
            return [];
        }
        $assets = [];
        $moduleCssFiles = $this->getLocalMagexpertsModuleCssFiles();
        foreach ($moduleCssFiles as $module => $cssFiles) {
            foreach ($cssFiles as $file) {
                // Example Expected: Magexperts_FastOrder::css/swatches.css
                $asset = $this->assetRepository->createAsset($module . '::' . $file);
                $assets[] = $asset->getUrl();
            }
        }

        return $assets;
    }

    /**
     * @return array
     * @codingStandardsIgnoreStart
     */
    public function getLocalMagexpertsModuleCssFiles()
    {
        $modules = $this->moduleList->getNames();
        $result = [];
        foreach ($modules as $moduleName) {
            if (strstr($moduleName, 'Magexperts_') === false
                || $moduleName === 'Magexperts_Core'
            ) {
                continue;
            }

            $moduleDir = $this->moduleReader->getModuleDir('', $moduleName);
            $moduleDir .= '/view/frontend/web/css';

            if (!file_exists($moduleDir)) continue;
            // find css file in recursive dir
            $dirIterator = new \RecursiveDirectoryIterator($moduleDir, \RecursiveDirectoryIterator::SKIP_DOTS);
            /** @var \SplFileInfo $file */
            foreach (new \RecursiveIteratorIterator($dirIterator) as $file) {
                $divide = explode('.', $file->getPathname());
                if (empty($ext = array_pop($divide)))
                    continue;
                if (strtolower($ext) == 'css') {
                    // Example Expected: /var/www/html/magento23/app/code/Magexperts/FastOrder/view/frontend/web/css/product/swatches.css
                    $filePath = str_replace('\\', '/', $file->getPathname());
                    $divide = explode('web/css', $filePath);
                    // Example Expected: product/swatches.css
                    $result[$moduleName][] = 'css' . array_pop($divide);
                }
            }
        }

        return $result;
    }
    //@codingStandardsIgnoreEnd

    /**
     * @return String
     */
    public function getCustomStyles()
    {
        return $this->helper->getCustomCss();
    }
}
