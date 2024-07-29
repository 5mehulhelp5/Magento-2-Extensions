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
 * @package    MAGEXPERTS_HtmlSiteMap
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\HtmlSiteMap\Model\Config\Product;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class ExcludeHtmlSiteMap
 * @package Magexperts\HtmlSiteMap\Model\Config\Product
 */
class ExcludeHtmlSiteMap extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [];
        $this->_options[] = ['label' => 'No', 'value' => '0'];
        $this->_options[] = ['label' => 'Yes', 'value' => '1'];
        return $this->_options;
    }
}
