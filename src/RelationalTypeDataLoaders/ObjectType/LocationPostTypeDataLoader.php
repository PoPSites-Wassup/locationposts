<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\RelationalTypeDataLoaders\ObjectType;

use PoPSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;
use PoPSchema\Posts\RelationalTypeDataLoaders\ObjectType\PostTypeDataLoader;

class LocationPostTypeDataLoader extends PostTypeDataLoader
{
    private ?LocationPostTypeAPIInterface $locationPostTypeAPI = null;

    final public function setLocationPostTypeAPI(LocationPostTypeAPIInterface $locationPostTypeAPI): void
    {
        $this->locationPostTypeAPI = $locationPostTypeAPI;
    }
    final protected function getLocationPostTypeAPI(): LocationPostTypeAPIInterface
    {
        return $this->locationPostTypeAPI ??= $this->instanceManager->getInstance(LocationPostTypeAPIInterface::class);
    }

    public function executeQuery($query, array $options = []): array
    {
        return $this->getLocationPostTypeAPI()->getLocationPosts($query, $options);
    }
}
