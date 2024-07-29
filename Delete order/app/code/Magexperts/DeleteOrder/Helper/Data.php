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
 * @package    Magexperts_DeleteOrder
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\DeleteOrder\Helper;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\ConfigOptionsListConstants;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var DeploymentConfig
     */
    protected $deploymentConfig;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        DeploymentConfig $deploymentConfig
    ) {
        parent::__construct($context);
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * @param null $name
     * @return bool|string|null
     */
    public function getTableName($name = null)
    {
        if ($name == null) {
            return false;
        }
        $tableName = $name;
        $tablePrefix = (string)$this->deploymentConfig->get(
            ConfigOptionsListConstants::CONFIG_PATH_DB_PREFIX
        );
        if ($tablePrefix) {
            $tableName = $tablePrefix . $name;
        }
        return $tableName;
    }
}
