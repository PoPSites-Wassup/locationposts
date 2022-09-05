<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts\ConditionalOnContext\AddLocationPostTypeToCustomPostUnionTypes\SchemaServices\ObjectTypeResolverPickers;

use PoP\ComponentModel\TypeResolvers\UnionType\UnionTypeResolverInterface;
use PoPCMSSchema\CustomPosts\TypeResolvers\UnionType\CustomPostUnionTypeResolver;
use PoPCMSSchema\LocationPosts\ObjectTypeResolverPickers\AbstractLocationPostObjectTypeResolverPicker;

class LocationPostCustomPostObjectTypeResolverPicker extends AbstractLocationPostObjectTypeResolverPicker
{
    /**
     * @return array<class-string<UnionTypeResolverInterface>>
     */
    public function getUnionTypeResolverClassesToAttachTo(): array
    {
        return [
            CustomPostUnionTypeResolver::class,
        ];
    }
}
