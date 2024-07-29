<?php
/**
 * This file is part of the Magexperts_SalesOrderGrid package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this package
 * to newer versions in the future.
 *
 * @author   Raj KB <rajkb@Magexperts.com>
 * @license  Open Software License (OSL 3.0)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Magexperts\SalesOrderGrid\Model;

use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

class StatusColor
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var JsonSerializer
     */
    private $jsonSerializer;

    /**
     * @var array
     */
    private $configValues;

    public function __construct(
        Config $config,
        JsonSerializer $jsonSerializer
    ) {
        $this->config = $config;
        $this->jsonSerializer = $jsonSerializer;
    }

    public function getColorByStatus($status)
    {
        $configValues = $this->getConfigValues();
        $defaultValue = 'transparent';
        if (empty($configValues)) {
            return $defaultValue;
        }
        $value = $defaultValue;
        foreach ($configValues as $data) {
            if ($data['order_status'] == $status) {
                $value = $data['color'];
                break;
            }
        }
        return $value;
    }

    public function getConfigValues()
    {
        if (!$this->configValues) {
            $configValues = $this->config->getGridStatusColor();
            if (empty($configValues)) {
                return $this->configValues = [];
            }
            if (is_array($configValues)) {
                return $this->configValues = $configValues;
            }
            $this->configValues = $this->jsonSerializer->unserialize($configValues);
        }

        return $this->configValues;
    }
}
