<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\XmlSitemap\Plugin\Magento\Sitemap\Model\ResourceModel\Cms;

use Magento\Sitemap\Model\ResourceModel\Cms\Page as Subject;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magexperts\XmlSitemap\Model\Config;

class Page
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepositoryInterface;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Config $config
    )
    {
        $this->pageRepositoryInterface = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->config = $config;
    }

    /**
     * @param Subject $subject
     * @param array $result
     * @return array
     */
    public function afterGetCollection(Subject $subject,array $result): array {
        if($result && $this->config->isEnabled()) {

            $searchCriteria = $this->searchCriteriaBuilder->addFilter('mf_exclude_xml_sitemap', 1, 'eq')->create();
            $excludedPages = $this->pageRepositoryInterface->getList($searchCriteria)->getItems();

            foreach ($result as $key => $page) {
                $key = (int)$key;
                if (isset($excludedPages[$key])) {
                    unset($result[$key]);
                }
            }
        }

        return $result;
    }
}