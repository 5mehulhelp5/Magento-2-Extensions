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
namespace Magexperts\HtmlSiteMap\Model\Config\Backend;


/**
 * Class ProcessCategory
 * @package Magexperts\HtmlSiteMap\Model\Config\Backend
 */
class ProcessCategory extends \Magento\Framework\App\Config\Value
{
    /**
     * @var Magento\Catalog\Model\CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category
     */
    private $categoryResource;

    /**
     * ProcessCategory constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magento\Catalog\Model\ResourceModel\Category $categoryResource
     * @param Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Catalog\Model\ResourceModel\Category $categoryResource,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryResource = $categoryResource;
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }
    /**
     * @inheritDoc
     *
     * @return \Magento\Config\Model\Config\Backend\Serialized $this
     * @throws \Exception
     * @SuppressWarnings(CyclomaticComplexity)
     */
    public function beforeSave()
    {
        /* @var array $value */
        $value = $this->getValue();
        $oldValue = $this->getOldValue();
        $storeId = $this->getScopeId();
        if ($oldValue) {
            $oldCategoryArray = explode(',', $oldValue);
        } else {
            $oldCategoryArray = [];
        }

        if ($value) {
            $newValueArray = explode(',', $value);
        } else {
            $newValueArray = [];
        }

        if ($value !== $oldValue) {
            //Check Add Category
            $enableCategoryArray = [];
            if (!empty($oldCategoryArray)) {
                foreach ($oldCategoryArray as $categoryId) {
                    if (!in_array($categoryId, $newValueArray)) {
                        $enableCategoryArray[] = $categoryId;
                    }
                }
            }

            //Enable Category
            foreach ($enableCategoryArray as $categoryId) {
                $categoryObject = $this->categoryRepository->get($categoryId, $storeId);
                $categoryObject->setData('excluded_html_sitemap', '0');
                $this->categoryResource->saveAttribute($categoryObject, 'excluded_html_sitemap');
            }

            foreach ($newValueArray as $categoryId) {
                $categoryObject = $this->categoryRepository->get($categoryId, $storeId);
                $categoryObject->setData('excluded_html_sitemap', '1');
                $this->categoryResource->saveAttribute($categoryObject, 'excluded_html_sitemap');
            }
        }
        return parent::beforeSave();
    }
}
