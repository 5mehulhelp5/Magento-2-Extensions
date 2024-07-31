<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\ResourceModel\Author;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magexperts\Blog\Api\AuthorCollectionInterface;

/**
 * Blog author collection
 */
class Collection extends AbstractCollection implements AuthorCollectionInterface
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'user_id';
    
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Magexperts\Blog\Model\Author::class, \Magexperts\Blog\Model\ResourceModel\Author::class);
    }
}
