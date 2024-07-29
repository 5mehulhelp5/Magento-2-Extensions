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
 * @package    Magexperts_LazyImageLoader
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\LazyImageLoader\Helper;

/**
 * Visitor Observer
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;

    /**
     * Data constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @param bool $html
     * @return bool
     */
    public function isEnabled($html = false)
    {
        $active =  $this->scopeConfig
            ->getValue('lazyimageloader/general/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($active != 1) {
            return false;
        }

        $full_action = $this->_request->getFullActionName();
        $module = $this->_request->getModuleName();
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();
        if ($full_action == '__') {
            $conditionalJsPattern = '#(<\!--\s*LAZYIMAGE.*LAZYIMAGE\s*-->)#isU';
            preg_match_all($conditionalJsPattern, $html, $_matches);
            $actions = implode('', $_matches[0]);
            $actions = explode('|', $actions);
            if (count($actions) > 1) {
                $full_action = $actions[1];
                $actions = explode('_', $full_action);
                $module = $actions[0];
                $controller = $actions[1];
                $action = $actions[2];
            }
        }

        //check home page
        $active =  $this->scopeConfig
            ->getValue('lazyimageloader/general/home_page', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($active == 1 && $full_action == 'cms_index_index') {
            return false;
        }
        //end

        //check controller
        if ($this->regexMatchSimple(
            $this->scopeConfig
                ->getValue('lazyimageloader/general/controller', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            "{$module}_{$controller}_{$action}",
            1
        )) {
            return false;
        }

        //check path
        if ($this->regexMatchSimple(
            $this->scopeConfig
                ->getValue('lazyimageloader/general/path', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            $this->_request->getRequestUri(),
            2
        )) {
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getThreshold()
    {
        return $this->scopeConfig
            ->getValue('lazyimageloader/general/threshold', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getLoadingWidth()
    {
        return $this->scopeConfig
            ->getValue('lazyimageloader/general/loading_width', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param $html
     * @return mixed
     */
    public function lazyLoad($html)
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $regex = '#<img class="product-image-photo([^>]*) src="([^"/]*/?[^".]*\.[^"]*)"(?!.*?notlazy)([^>]*)>#';
            if (preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])) {
                $replace = '<noscript><img$1 src="$2" $3></noscript>';
                $replace .= '<img class="product-image-photo lazy$1
	             src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="$2"$3>';
            } else {
                $replace = '<img class="product-image-photo lazy$1
	   src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" srcset="" data-src="$2"$3>';
            }
            $html = preg_replace($regex, $replace, $html);
        }
        return $html;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLazyImage()
    {
        $img =  $this->scopeConfig
            ->getValue('lazyimageloader/general/loading', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (!$img || $img == '') {
            return $this->getLazyImg();
        }
        return $this->storeManager
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'lazyimage'.DIRECTORY_SEPARATOR.$img;
    }

    /**
     * @param $regex
     * @param $matchTerm
     * @param $type
     * @return bool
     */
    public function regexMatchSimple($regex, $matchTerm, $type)
    {

        if (!$regex) {
            return false;
        }

        $rules = unserialize($regex);

        if (empty($rules)) {
            return false;
        }

        foreach ($rules as $rule) {
            $regex = trim($rule['lazyimage'], '#');
            if ($type == 1) {
                $regexs = explode('_', $regex);
                switch ($this->countArray($regexs)) {
                    case 1:
                        $regex = $regex.'_index_index';
                        break;
                    case 2:
                        $regex = $regex.'_index';
                        break;
                    default:
                        break;
                }
            }

            $regexp = '#' . $regex . '#';
            if (preg_match($regexp, $matchTerm)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $array
     * @return int
     */
    public function countArray($array)
    {
        return count($array);
    }

    /**
     * @return string
     */
    protected function getLazyImg()
    {
        return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    }

    public function getFullActionName()
    {
        return '<!-- LAZYIMAGE |'.$this->_request->getFullActionName().'| LAZYIMAGE -->';
    }
}
