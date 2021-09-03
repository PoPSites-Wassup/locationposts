<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\TypeResolvers\Object;

use PoPSchema\LocationPosts\Environment;
use PoPSchema\Posts\TypeResolvers\Object\PostTypeResolver;
use PoPSchema\LocationPosts\RelationalTypeDataLoaders\Object\LocationPostTypeDataLoader;

class LocationPostTypeResolver extends PostTypeResolver
{
    protected static ?string $name = null;

    public function getTypeName(): string
    {
        if (is_null(self::$name)) {
            self::$name = Environment::getLocationPostTypeName() ?? 'LocationPost';
        }
        return self::$name;
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('A post which has locations', 'locationposts');
    }

    public function getRelationalTypeDataLoaderClass(): string
    {
        return LocationPostTypeDataLoader::class;
    }
}
