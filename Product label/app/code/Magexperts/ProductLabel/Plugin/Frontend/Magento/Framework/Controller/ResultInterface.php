<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Plugin\Frontend\Magento\Framework\Controller;

use Magento\Framework\Controller\ResultInterface as Subject;
use Magento\Framework\App\ResponseInterface;
use Magexperts\ProductLabel\Model\Parser\Html;
use Magexperts\ProductLabel\Model\Config;

class ResultInterface
{
    /**
     * @var Html
     */
    protected $htmlParser;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Html $htmlParser
     * @param Config $config
     */
    public function __construct(
        Html $htmlParser,
        Config $config
    )
    {
        $this->htmlParser = $htmlParser;
        $this->config = $config;
    }

    /**
     * @param Subject $subject
     * @param Subject $result
     * @param ResponseInterface $response
     * @return Subject
     */
    public function afterRenderResult(
        Subject $subject,
        Subject $result,
        ResponseInterface $response
    ) {
        $html = $response->getBody();

        if ($this->config->isEnabled() && (false !== strpos($html, Html::COMMENT_PREFIX))) {
            $response->setBody($this->htmlParser->execute($html));
        }

        return $result;
    }
}
