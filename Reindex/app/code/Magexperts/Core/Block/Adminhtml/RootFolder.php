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
namespace Magexperts\Core\Block\Adminhtml;

use Magento\Framework\App\Filesystem\DirectoryList;

class RootFolder extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * @var \Magento\Framework\Filesystem\Directory\Write
     */
    private $directory;

    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $zendClientFactory;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\View\Helper\Js $jsHelper
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Http\ZendClientFactory $httpClientFactory
     * @param array $data
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        array $data = []
    ) {
        $this->filesystem = $filesystem;
        $this->zendClientFactory = $httpClientFactory;
        parent::__construct($context, $authSession, $jsHelper, $data);
    }

    /**
     * Init root directory
     *
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function _construct()
    {
        $this->directory = $this->filesystem->getDirectoryWrite(DirectoryList::ROOT);
        parent::_construct();
    }

    /**
     * Return header html for 'Magento root path' fieldset.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return mixed|string
     */
    protected function _getHeaderHtml($element)
    {
        $headerHtml = parent::_getHeaderHtml($element);

        try {
            $debugInfo[] = "Magento Root Path: " . $this->directory->getAbsolutePath();
        } catch (\Exception $e) {
            $debugInfo[] = "Can't find root directory.";
        }

        $headerHtml = str_replace(
            '<table cellspacing="0" class="form-list">',
            implode("<br/>", $debugInfo) . '<table cellspacing="0" class="form-list">',
            $headerHtml
        );
        return $headerHtml;
    }
}
