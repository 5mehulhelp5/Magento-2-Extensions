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
 * @package    Magexperts_Reindex
 * @author     Extension Team
 * @copyright  Copyright (c) 2015-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Reindex\Block\Backend\Grid;

class ItemsUpdater extends \Magento\Indexer\Block\Backend\Grid\ItemsUpdater
{
    public function update($argument)
    {
        if (false === $this->authorization->isAllowed('Magento_Indexer::changeMode')) {
            unset($argument['change_mode_onthefly']);
            unset($argument['change_mode_changelog']);
        }
        if (false === $this->authorization->isAllowed('Magexperts_Reindex::reindexdata')) {
            unset($argument['change_mode_reindex']);
        }
        return $argument;
    }
}
