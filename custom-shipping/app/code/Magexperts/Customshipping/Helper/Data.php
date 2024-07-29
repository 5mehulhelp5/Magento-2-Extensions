<?php
namespace Magexperts\Customshipping\Helper;

/**
 * @category   Magexperts
 * @package    Magexperts_Customshipping
 * @author     Magexperts@gmail.com
 * @website    http://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	const XML_PATH_ENABLED          = 'Magexperts_customshipping/general/enabled';
	const XML_PATH_DEBUG            = 'Magexperts_customshipping/general/debug';

	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	protected $_logger;

	/**
	 * @var \Magento\Framework\Module\ModuleListInterface
	 */
	protected $_moduleList;

	/**
	 * @param \Magento\Framework\App\Helper\Context $context
	 * @param \Magento\Framework\Module\ModuleListInterface $moduleList
	 */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Module\ModuleListInterface $moduleList
	) {
		$this->_logger                  = $context->getLogger();
		$this->_moduleList              = $moduleList;

		parent::__construct($context);
	}

	/**
	 * Check if enabled
	 *
	 * @return string|null
	 */
	public function isEnabled()
	{
		return $this->scopeConfig->getValue(
			self::XML_PATH_ENABLED,
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	public function getDebugStatus()
	{
		return $this->scopeConfig->getValue(
			self::XML_PATH_DEBUG,
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	public function getExtensionVersion()
	{
		$moduleCode = 'Magexperts_Customshipping';
		$moduleInfo = $this->_moduleList->getOne($moduleCode);
		return $moduleInfo['setup_version'];
	}

	/**
	 *
	 * @param $message
	 * @param bool|false $useSeparator
	 */
	public function log($message, $useSeparator = false)
	{
		if ($this->getDebugStatus()) {
			if ($useSeparator) {
				$this->_logger->addDebug(str_repeat('=', 100));
			}

			$this->_logger->addDebug($message);
		}
	}
}