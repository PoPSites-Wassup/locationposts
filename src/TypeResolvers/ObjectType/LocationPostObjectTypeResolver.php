<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoPCMSSchema\LocationPosts\Environment;
use PoPCMSSchema\LocationPosts\RelationalTypeDataLoaders\ObjectType\LocationPostTypeDataLoader;
use PoPCMSSchema\Posts\TypeResolvers\ObjectType\PostObjectTypeResolver;

class LocationPostObjectTypeResolver extends PostObjectTypeResolver
{
    protected ?string $name = null;

    private ?LocationPostTypeDataLoader $locationPostTypeDataLoader = null;

    final public function setLocationPostTypeDataLoader(LocationPostTypeDataLoader $locationPostTypeDataLoader): void
    {
        $this->locationPostTypeDataLoader = $locationPostTypeDataLoader;
    }
    final protected function getLocationPostTypeDataLoader(): LocationPostTypeDataLoader
    {
        /** @var LocationPostTypeDataLoader */
        return $this->locationPostTypeDataLoader ??= $this->instanceManager->getInstance(LocationPostTypeDataLoader::class);
    }

    public function getTypeName(): string
    {
        if ($this->name === null) {
            $this->name = Environment::getLocationPostTypeName() ?? 'LocationPost';
        }
        return $this->name;
    }

    public function getTypeDescription(): ?string
    {
        return $this->__('A post which has locations', 'locationposts');
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getLocationPostTypeDataLoader();
    }
}
