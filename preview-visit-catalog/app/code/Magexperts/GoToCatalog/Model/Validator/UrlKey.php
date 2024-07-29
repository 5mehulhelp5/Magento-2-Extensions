<?php

namespace Magexperts\GoToCatalog\Model\Validator;

use Magento\Framework\App\Route\ConfigInterface as RouteConfig;
use Magexperts\GoToCatalog\Helper\Data as GoToCatalogHelper;

/**
 * @category   Magexperts
 * @package    Magexperts_GoToCatalog
 * @author     Raj KB <info@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class UrlKey
{
    /**
     * @var RouteConfig
     */
    private $routeConfig;

    /**
     * @var GoToCatalogHelper
     */
    private $goToCatalogHelper;

    public function __construct(
        RouteConfig $routeConfig,
        GoToCatalogHelper $goToCatalogHelper
    ) {
        $this->routeConfig = $routeConfig;
        $this->goToCatalogHelper = $goToCatalogHelper;
    }

    /**
     * @param $urlKey
     * @return bool
     */
    public function validate($urlKey): bool
    {
        $modules = $this->routeConfig->getModulesByFrontName($urlKey, 'frontend');
        return !empty($modules);
    }
}
