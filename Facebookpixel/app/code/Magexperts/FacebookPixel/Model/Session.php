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
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2023 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\FacebookPixel\Model;

/**
 * Class Session
 *
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class Session extends \Magento\Framework\Session\SessionManager
{
    /**
     * Set data add to cart
     *
     * @param array $data
     * @return \Magexperts\FacebookPixel\Model\Session $this
     */
    public function setAddToCart($data)
    {
        $this->storage->setData('add_to_cart', $data);
        return $this;
    }

    /**
     * Get data add to cart
     *
     * @return mixed|null
     */
    public function getAddToCart()
    {
        if ($this->hasAddToCart()) {
            $data = $this->getData('add_to_cart');
            $this->storage->unsetData('add_to_cart');
            return $data;
        }
        return null;
    }

    /**
     * Has added to cart
     *
     * @return bool
     */
    public function hasAddToCart()
    {
        return $this->storage->hasData('add_to_cart');
    }

    /**
     * Set data add to wish list
     *
     * @param array $data
     * @return \Magexperts\FacebookPixel\Model\Session $this
     */
    public function setAddToWishlist($data)
    {
        $this->storage->setData('add_to_wishlist', $data);
        return $this;
    }

    /**
     * Get data add to wish list
     *
     * @return mixed|null
     */
    public function getAddToWishlist()
    {
        if ($this->hasAddToWishlist()) {
            $data = $this->getData('add_to_wishlist');
            $this->storage->unsetData('add_to_wishlist');
            return $data;
        }
        return null;
    }

    /**
     * Has added data to wishlist
     *
     * @return mixed
     */
    public function hasAddToWishlist()
    {
        return $this->storage->hasData('add_to_wishlist');
    }

    /**
     * Set data to subscribe
     *
     * @param array $data
     * @return \Magexperts\FacebookPixel\Model\Session $this
     */
    public function setAddSubscribe($data)
    {
        $this->storage->setData('add_subscribe', $data);
        return $this;
    }

    /**
     * Get add subscribe
     *
     * @return mixed|null
     */
    public function getAddSubscribe()
    {
        if ($this->hasAddSubscribe()) {
            $data = $this->getData('add_subscribe');
            $this->storage->unsetData('add_subscribe');
            return $data;
        }
        return null;
    }

    /**
     * Has add subscribe
     *
     * @return bool
     */
    public function hasAddSubscribe()
    {
        return $this->storage->hasData('add_subscribe');
    }

    /**
     * Has init checkout
     *
     * @return bool
     */
    public function hasInitiateCheckout()
    {
        return $this->storage->hasData('initiate_checkout');
    }

    /**
     * Set init checkout
     *
     * @param array $data
     * @return \Magexperts\FacebookPixel\Model\Session $this
     */
    public function setInitiateCheckout($data)
    {
        $this->storage->setData('initiate_checkout', $data);
        return $this;
    }

    /**
     * Get init checkout
     *
     * @return mixed|null
     */
    public function getInitiateCheckout()
    {
        if ($this->hasInitiateCheckout()) {
            $data = $this->getData('initiate_checkout');
            $this->storage->unsetData('initiate_checkout');
            return $data;
        }
        return null;
    }

    /**
     * Has search
     *
     * @return bool
     */
    public function hasSearch()
    {
        return $this->storage->hasData('search');
    }

    /**
     * Set search
     *
     * @param array $data
     * @return $this
     */
    public function setSearch($data)
    {
        $this->storage->setData('search', $data);
        return $this;
    }

    /**
     * Get search
     *
     * @return mixed|null
     */
    public function getSearch()
    {
        if ($this->hasSearch()) {
            $data = $this->getData('search');
            $this->storage->unsetData('search');
            return $data;
        }
        return null;
    }

    /**
     * Has register
     *
     * @return bool
     */
    public function hasRegister()
    {
        return $this->storage->hasData('customer_register');
    }

    /**
     * Set register
     *
     * @param array $data
     * @return $this
     */
    public function setRegister($data)
    {
        $this->storage->setData('customer_register', $data);
        return $this;
    }

    /**
     * Get register
     *
     * @return mixed|null
     */
    public function getRegister()
    {
        if ($this->hasRegister()) {
            $data = $this->getData('customer_register');
            $this->storage->unsetData('customer_register');
            return $data;
        }
        return null;
    }

    /**
     * Set action page
     *
     * @param array $data
     * @return $this
     */
    public function setActionPage($data)
    {
        $this->storage->setData('bss_action_page', $data);
        return $this;
    }

    /**
     * Get action page
     *
     * @return mixed|null
     */
    public function getActionPage()
    {
        if ($this->hasActionPage()) {
            $data = $this->getData('bss_action_page');
            $this->storage->unsetData('bss_action_page');
            return $data;
        }
        return null;
    }

    /**
     * Has action page
     *
     * @return bool
     */
    public function hasActionPage()
    {
        return $this->storage->hasData('bss_action_page');
    }
}
