<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Plugin\BackendMenu;

use Magento\Backend\Model\Menu\Item as NativeItem;

class Item
{
    /**
     * @param NativeItem $subject
     * @param $url
     * @return string
     */
    public function afterGetUrl(NativeItem $subject, $url)
    {
        $id = $subject->getId();
        if ($id == 'Magexperts_Core::marketplace') {
            return 'https://www.magexperts.com/magento-2-extensions.html?utm_source=extensions_promo&utm_medium=backend&utm_campaign=from_magento_2_menu';
        } else {
            return $url;
        }
    }
}
