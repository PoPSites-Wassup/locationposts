<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ConditionalOnContext\AddLocationPostTypeToCustomPostUnionTypes\SchemaServices\ObjectTypeResolverPickers;

use PoPSchema\CustomPosts\TypeResolvers\Union\CustomPostUnionTypeResolver;
use PoPSchema\LocationPosts\ObjectTypeResolverPickers\AbstractLocationPostTypeResolverPicker;

class LocationPostCustomPostTypeResolverPicker extends AbstractLocationPostTypeResolverPicker
{
    public function getUnionTypeResolverClassesToAttachTo(): array
    {
        return [
            CustomPostUnionTypeResolver::class,
        ];
    }
}
