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
 * @category  Magexperts
 * @package   Magexperts_Limitcartqty
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Limitcartqty\Api;

interface DataConfigInterface
{
    /**
     * MinValue
     *
     * @return mixed
     */
    public function getMinValue();

    /**
     * MaxValue
     *
     * @return mixed
     */
    public function getMaxValue();

    /**
     * CustomerId
     *
     * @return mixed
     */
    public function getCustomerId();

    /**
     * Store Id
     *
     * @return mixed
     */
    public function getStoreId();
}
