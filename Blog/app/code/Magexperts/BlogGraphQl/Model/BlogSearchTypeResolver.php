<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare (strict_types = 1);

namespace Magexperts\BlogGraphQl\Model;

use Magento\Framework\GraphQl\Query\Resolver\TypeResolverInterface;

/**
 * @inheritdoc
 */
class BlogSearchTypeResolver implements TypeResolverInterface
{
    const MF_BLOG_SEARCH = 'MF_BLOG_SEARCH';
    const TYPE_RESOLVER = 'blogPostsOutput';

    /**
     * @inheritdoc
     */
    public function resolveType(array $data) : string
    {
        if (isset($data['type_id']) && $data['type_id'] == self::MF_BLOG_SEARCH) {
            return self::TYPE_RESOLVER;
        }
        return '';
    }
}
