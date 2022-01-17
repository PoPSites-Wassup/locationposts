<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts\ConditionalOnContext\AddLocationPostTypeToCustomPostUnionTypes\SchemaServices\ObjectTypeResolverPickers;

use PoPCMSSchema\CustomPosts\TypeResolvers\UnionType\CustomPostUnionTypeResolver;
use PoPCMSSchema\LocationPosts\ObjectTypeResolverPickers\AbstractLocationPostObjectTypeResolverPicker;

class LocationPostCustomPostObjectTypeResolverPicker extends AbstractLocationPostObjectTypeResolverPicker
{
    public function getUnionTypeResolverClassesToAttachTo(): array
    {
        return [
            CustomPostUnionTypeResolver::class,
        ];
    }
}
