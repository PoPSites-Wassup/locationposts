<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ConditionalOnContext\AddLocationPostTypeToCustomPostUnionTypes\SchemaServices\ObjectTypeResolverPickers;

use PoPSchema\CustomPosts\TypeResolvers\UnionType\CustomPostUnionTypeResolver;
use PoPSchema\LocationPosts\ObjectTypeResolverPickers\AbstractLocationPostObjectTypeResolverPicker;

class LocationPostCustomPostObjectTypeResolverPicker extends AbstractLocationPostObjectTypeResolverPicker
{
    public function getUnionTypeResolverClassesToAttachTo(): array
    {
        return [
            CustomPostUnionTypeResolver::class,
        ];
    }
}
