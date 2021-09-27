<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ObjectTypeResolverPickers;

use PoP\ComponentModel\ObjectTypeResolverPickers\AbstractObjectTypeResolverPicker;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;
use PoPSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;
use PoPSchema\LocationPosts\TypeResolvers\ObjectType\LocationPostObjectTypeResolver;

abstract class AbstractLocationPostObjectTypeResolverPicker extends AbstractObjectTypeResolverPicker
{
    public function __construct(
        protected LocationPostObjectTypeResolver $locationPostObjectTypeResolver,
        protected LocationPostTypeAPIInterface $locationPostTypeAPI,
    ) {
    }

    public function getObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->locationPostObjectTypeResolver;
    }

    public function isInstanceOfType(object $object): bool
    {
        return $this->locationPostTypeAPI->isInstanceOfLocationPostType($object);
    }

    public function isIDOfType(string | int $objectID): bool
    {
        return $this->locationPostTypeAPI->locationPostExists($objectID);
    }
}
