<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ObjectTypeResolverPickers;

use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;
use PoPSchema\LocationPosts\TypeResolvers\ObjectType\LocationPostTypeResolver;
use PoP\ComponentModel\ObjectTypeResolverPickers\AbstractObjectTypeResolverPicker;

abstract class AbstractLocationPostTypeResolverPicker extends AbstractObjectTypeResolverPicker
{
    public function getObjectTypeResolverClass(): string
    {
        return LocationPostTypeResolver::class;
    }

    public function isInstanceOfType(object $object): bool
    {
        $locationPostTypeAPI = LocationPostTypeAPIFacade::getInstance();
        return $locationPostTypeAPI->isInstanceOfLocationPostType($object);
    }

    public function isIDOfType(string | int $resultItemID): bool
    {
        $locationPostTypeAPI = LocationPostTypeAPIFacade::getInstance();
        return $locationPostTypeAPI->locationPostExists($resultItemID);
    }
}
