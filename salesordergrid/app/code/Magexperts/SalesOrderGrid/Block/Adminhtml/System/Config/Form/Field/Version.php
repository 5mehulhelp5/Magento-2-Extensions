<?php
/**
 * This file is part of the Magexperts_SalesOrderGrid package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this package
 * to newer versions in the future.
 *
 * @author   Raj KB <rajkb@Magexperts.com>
 * @license  Open Software License (OSL 3.0)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Magexperts\SalesOrderGrid\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magexperts\SalesOrderGrid\Model\Config\ModuleMetadata;
use Magexperts\SalesOrderGrid\Helper\Data as SalesOrderGridHelper;

class Version extends Field
{
    /**
     * @var SalesOrderGridHelper
     */
    protected $goToCatalogHelper;

    /**
     * @var ModuleMetadata
     */
    private $moduleMetadata;

    public function __construct(
        Context $context,
        SalesOrderGridHelper $goToCatalogHelper,
        ModuleMetadata $moduleMetadata
    ) {
        $this->goToCatalogHelper = $goToCatalogHelper;
        $this->moduleMetadata = $moduleMetadata;
        parent::__construct($context);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        if ($this->moduleMetadata->soldViaMagentoMarketplace()) {
            $versionLabel = $this->moduleMetadata->getVersion();
        } else {
            $versionLabel = sprintf(
                '<a href="%s" title="%s" target="_blank">%s</a>',
                $this->moduleMetadata->getUrl(),
                $this->moduleMetadata->getName(),
                $this->moduleMetadata->getVersion()
            );
        }
        $element->setValue($versionLabel);

        return $element->getValue();
    }
}
