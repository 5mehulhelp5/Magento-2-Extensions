<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Controller\Adminhtml;

/**
 * Class Rule
 */
class Rule extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'autorp_rule_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Magexperts_AutoRelatedProduct::rule';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = 'Magexperts\AutoRelatedProduct\Model\Rule';

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Magexperts_AutoRelatedProduct::rule';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';
}
