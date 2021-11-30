<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ObjectTypeResolverPickers;

use PoP\ComponentModel\ObjectTypeResolverPickers\AbstractObjectTypeResolverPicker;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;
use PoPSchema\LocationPosts\TypeResolvers\ObjectType\LocationPostObjectTypeResolver;

abstract class AbstractLocationPostObjectTypeResolverPicker extends AbstractObjectTypeResolverPicker
{
    private ?LocationPostObjectTypeResolver $locationPostObjectTypeResolver = null;
    private ?LocationPostTypeAPIInterface $locationPostTypeAPI = null;

    final public function setLocationPostObjectTypeResolver(LocationPostObjectTypeResolver $locationPostObjectTypeResolver): void
    {
        $this->locationPostObjectTypeResolver = $locationPostObjectTypeResolver;
    }
    final protected function getLocationPostObjectTypeResolver(): LocationPostObjectTypeResolver
    {
        return $this->locationPostObjectTypeResolver ??= $this->instanceManager->getInstance(LocationPostObjectTypeResolver::class);
    }
    final public function setLocationPostTypeAPI(LocationPostTypeAPIInterface $locationPostTypeAPI): void
    {
        $this->locationPostTypeAPI = $locationPostTypeAPI;
    }
    final protected function getLocationPostTypeAPI(): LocationPostTypeAPIInterface
    {
        return $this->locationPostTypeAPI ??= $this->instanceManager->getInstance(LocationPostTypeAPIInterface::class);
    }

    public function getObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->getLocationPostObjectTypeResolver();
    }

    public function isInstanceOfType(object $object): bool
    {
        return $this->getLocationPostTypeAPI()->isInstanceOfLocationPostType($object);
    }

    public function isIDOfType(string | int $objectID): bool
    {
        return $this->getLocationPostTypeAPI()->locationPostExists($objectID);
    }
}
