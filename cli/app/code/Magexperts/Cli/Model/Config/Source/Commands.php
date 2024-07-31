<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\Cli\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Console\CommandListInterface;

/**
 * Options provider for most used commands
 */
class Commands implements OptionSourceInterface
{
    /**
     * Options array
     *
     * @var array
     */
    private $options;

    /**
     * @var CommandListInterface
     */
    private $commandList;

    public function __construct(
        CommandListInterface $commandList
    ) {
        $this->commandList = $commandList;
    }

    /**
     * Return options array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if (!$this->options) {
            $commands = $this->commandList->getCommands();
            foreach ($commands as $command) {
                $this->options[] = ['value' => $command->getName(), 'label' => $command->getName()];
            }
            array_unshift($this->options, ['value' => '', 'label' => __('-- None --')]);
        }
        return $this->options;
    }
}
