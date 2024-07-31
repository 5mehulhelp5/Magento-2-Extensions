<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\ViewModel;

use Magento\Framework\View\Asset\Source;
use Magento\Framework\View\Asset\Repository as AssetRepository;

/**
 * Class AbstractCss
 */
class Style implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    private $assetRepository;

    /**
     * @var Source
     */
    private $source;

    /**
     * @var array
     */
    private $done = [];

    /**
     * Style constructor.
     * @param Source $source
     * @param AssetRepository $assetRepository
     */
    public function __construct(
        Source $source,
        AssetRepository $assetRepository
    ) {
        $this->source = $source;
        $this->assetRepository = $assetRepository;
    }

    /**
     * @return null|string
     */
    public function getStyle($file)
    {
        if (isset($this->done[$file])) {
            return '';
        }
        $this->done[$file] = true;

        if (false === strpos($file, '::')) {
            $file = 'Magexperts_Blog::css/' . $file;
        }

        if (false === strpos($file, '.css')) {
            $file = $file . '.css';
        }

        $shortFileName = $file;

        $asset = $this->assetRepository->createAsset($file);

        $fileContent = '';

        $file = $this->source->getFile($asset);
        if (!$file || !file_exists($file)) {
            $file = $this->source->findRelativeSourceFilePath($asset);
            if ($file && !file_exists($file)) {
                $file = '../' . $file;

            }
        }

        if ($file && file_exists($file)) {
            $fileContent = file_get_contents($file);
        }

        $fileContent = str_replace(
            'url(../',
            ' url(' . dirname($asset->getUrl('')) . '/../',
            $fileContent
        );

        if (!trim($fileContent)) {
            $fileContent = '/* ' .  $shortFileName . '.css is empty */';
        }

        return PHP_EOL . '
        <!-- Start CSS ' . $shortFileName . ' ' . ((int)(strlen($fileContent) / 1024)) . 'Kb -->
        <style>' . $fileContent . '</style>';
    }
}
