<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Cron;

use Magexperts\Community\Model\SectionFactory;
use Magexperts\Community\Model\Section\Info;
use Magexperts\Community\Model\SetLinvFlag;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Sections
 * @package Magexperts\Community
 */
class Sections
{
    /**
     * @var SectionFactory
     */
    protected $sectionFactory;

    /**
     * @var Info
     */
    protected $info;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var SetLinvFlag
     */
    private $setLinvFlag;

    /**
     * Sections constructor.
     * @param ResourceConnection $resource
     * @param SectionFactory $sectionFactory
     * @param Info $info
     */
    public function __construct(
        ResourceConnection $resource,
        SectionFactory $sectionFactory,
        Info $info,
        SetLinvFlag $setLinvFlag
    ) {
        $this->resource = $resource;
        $this->sectionFactory = $sectionFactory;
        $this->info = $info;
        $this->setLinvFlag = $setLinvFlag;
    }

    /**
     * Execute cron job
     */
    public function execute()
    {
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('core_config_data');
        $path = 'gen' . 'er' . 'al'. '/' . 'ena' . 'bled';

        $select = $connection->select()->from(
            [$table]
        )->where(
            'path LIKE ?',
            '%' . $path
        );

        $sections = [];
        foreach ($connection->fetchAll($select) as $config) {
            $matches = false;
            preg_match("/(.*)\/" . str_replace('/', '\/', $path) . "/", $config['path'], $matches);
            if (empty($matches[1])) {
                continue;
            }
            $section = $this->sectionFactory->create([
                'name' => $matches[1]
            ]);

            if ($section->getModule()) {
                $sections[$section->getModule()] = $section;
            } else {
                unset($section);
            }
        }

        if (count($sections)) {
            $data = $this->info->load($sections);

            if ($data && is_array($data)) {
                foreach ($data as $module => $item) {
                    $section = $sections[$module];
                    $moduleName = $section->getName();
                    if (!$section->validate($data)) {
                        $connection->update(
                            $table,
                            [
                                'value' => 0
                            ],
                            ['path = ? ' => $section->getName() . '/' . $path]
                        );
                        $this->setLinvFlag->execute($moduleName, 1);
                    } else {
                        $this->setLinvFlag->execute($moduleName, 0);
                    }
                }
            }
        }
    }
}
