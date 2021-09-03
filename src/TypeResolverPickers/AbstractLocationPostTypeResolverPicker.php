<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\TypeResolverPickers;

use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;
use PoPSchema\LocationPosts\TypeResolvers\LocationPostTypeResolver;
use PoP\ComponentModel\TypeResolverPickers\AbstractObjectTypeResolverPicker;

class AbstractLocationPostTypeResolverPicker extends AbstractObjectTypeResolverPicker
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
