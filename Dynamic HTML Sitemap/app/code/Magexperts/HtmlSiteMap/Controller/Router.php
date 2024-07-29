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
namespace Magexperts\HtmlSiteMap\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;

/**
 * Class Router
 * @package Magexperts\HtmlSiteMap\Controller
 */
class Router implements RouterInterface
{
    /**
     * @var bool
     */
    private $dispatched = false;

    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var CustomRouteHelper
     */
    protected $helper;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    /**
     * @var ResultFactory
     */
    private $resultFactory;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Router constructor.
     * @param ActionFactory $actionFactory
     * @param EventManagerInterface $eventManager
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param ResultFactory $resultFactory
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magexperts\HtmlSiteMap\Helper\Data $helper
     */
    public function __construct(
        ActionFactory $actionFactory,
        EventManagerInterface $eventManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magexperts\HtmlSiteMap\Helper\Data $helper
    ) {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->helper = $helper;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->storeManager = $storeManager;
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        if (!$this->dispatched) {
            $identifier = trim($request->getPathInfo(), '/');
            $this->eventManager->dispatch('core_controller_router_match_before', [
                'router' => $this,
                'condition' => new DataObject(['identifier' => $identifier, 'continue' => true])
            ]);
            $stores = $this->storeManager->getStores(false);

            $routeObject = [];
            foreach ($stores as $store) {
                $storeId = $store->getId();
                $route = $this->helper->getModuleRoute($storeId);
                if (!in_array($route, $routeObject)) {
                    $routeObject[] = $route;
                }
            }

            if (in_array($identifier, $routeObject)) {
                $request->setModuleName('custom_route')
                    ->setControllerName('index')
                    ->setActionName('index');
                $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);
                $this->dispatched = true;

                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Forward'
                );
            }

            return null;
        }
        return null;
    }

    /**
     * @return $this|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $redirectUrl= $this->url->getUrl('');
        $isEnabled = $this->helper->isEnable();
        $title = $this->helper->getTitleSiteMap();
        $description = $this->helper->getDescriptionSitemap();
        $keywords = $this->helper->getKeywordsSitemap();
        $metaTitle = $this->helper->getMetaTitleSitemap();
        if ($isEnabled) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__($title));
            $resultPage->getConfig()->setDescription($description);
            $resultPage->getConfig()->setKeywords($keywords);
            $resultPage->getConfig()->setMetadata('meta_title', $metaTitle);
            return $resultPage;
        } else {
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($redirectUrl);
        }
    }
}
