<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magexperts\Smtp\Model\Config\Options\Status as StatusOptions;

/**
 * Class Status
 */
class Status extends Column
{
    /**
     * @var StatusOptions
     */
    private $statusOptions;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StatusOptions $statusOptions,
        array $components = [],
        array $data = []
    ) {
        $this->statusOptions = $statusOptions;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->getLabelByStatus($item[$this->getData('name')]);
            }
        }

        return $dataSource;
    }

    /**
     * @param $status
     * @return string
     */
    private function getLabelByStatus($status)
    {
        $html = '';
        $label = $this->statusOptions->getLabelByStatus($status);
        switch ($status) {
            case StatusOptions::STATUS_SUCCESS:
                $html = '<span class="grid-severity-notice"><span>'
                    . $label . '</span></span>';
                break;
            case StatusOptions::STATUS_FAILED:
                $html = '<span class="grid-severity-major"><span>'
                    . $label . '</span></span>';
                break;
            default:
                $html = '<span class="grid-severity-minor"><span>'
                    . $label . '</span></span>';
                break;
        }

        return $html;
    }
}
