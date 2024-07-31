<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magexperts\Community\Model\SectionFactory;
use Magexperts\Community\Model\Section\Info;
use Magento\Framework\Message\ManagerInterface;
use Magexperts\Community\Model\SetLinvFlag;

/**
 * Community observer
 */
class ConfigObserver implements ObserverInterface
{
    /**
     * @var SectionFactory
     */
    private $sectionFactory;

    /**
     * @var Info
     */
    private $info;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var SetLinvFlag
     */
    private $setLinvFlag;

    /**
     * ConfigObserver constructor.
     * @param SectionFactory $sectionFactory
     * @param Info $info
     * @param ManagerInterface $messageManager
     */
    final public function __construct(
        SectionFactory $sectionFactory,
        Info $info,
        ManagerInterface $messageManager,
        SetLinvFlag $setLinvFlag
    ) {
        $this->sectionFactory = $sectionFactory;
        $this->info = $info;
        $this->messageManager = $messageManager;
        $this->setLinvFlag = $setLinvFlag;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    final public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        $groups = $request->getParam('groups');
        if (empty($groups['general']['fields']['enabled']['value'])) {
            return;
        }

        $key = isset($groups['general']['fields']['key']['value'])
            ? $groups['general']['fields']['key']['value']
            : null;

        $section = $this->sectionFactory->create([
            'name' => $request->getParam('section'),
            'key' => $key
        ]);

        if (!$section->getModule()) {
            return;
        }
        $module = $section->getName();
        $data = $this->info->load([$section]);

        if (!$section->validate($data)) {
            $groups['general']['fields']['enabled']['value'] = 0;
            $this->setLinvFlag->execute($module, 1);
            $request->setPostValue('groups', $groups);

            $this->messageManager->addError(
                implode(array_reverse(
                    [
                        '.','d','e','l','b','a','s','i','d',' ','y','l','l','a','c','i','t','a','m',
                        'o','t','u','a',' ','n','e','e','b',' ','s','a','h',' ','n','o','i','s','n',
                        'e','t','x','e',' ','e','h','T',' ','.','d','i','l','a','v','n','i',' ','r',
                        'o',' ','y','t','p','m','e',' ','s','i',' ','y','e','K',' ','t','c','u','d',
                        'o','r','P'
                    ]
                ))
            );
        } else {
            $this->setLinvFlag->execute($module, 0);
        }
    }
}
