<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\BlogGraphQl\Model;

use Magento\Framework\GraphQl\Query\Resolver\TypeResolverInterface;

/**
 * @inheritdoc
 */
class BlogIndexTypeResolver implements TypeResolverInterface
{
    const MF_BLOG_INDEX = 'MF_BLOG_INDEX';
    const TYPE_RESOLVER = 'blogPostsOutput';

    /**
     * @inheritdoc
     */
    public function resolveType(array $data) : string
    {
        if (isset($data['type_id']) && $data['type_id'] == self::MF_BLOG_INDEX) {
            return self::TYPE_RESOLVER;
        }
        return '';
    }
}
