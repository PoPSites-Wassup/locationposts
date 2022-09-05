<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts\RelationalTypeDataLoaders\ObjectType;

use PoPCMSSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;
use PoPCMSSchema\Posts\RelationalTypeDataLoaders\ObjectType\PostTypeDataLoader;

class LocationPostTypeDataLoader extends PostTypeDataLoader
{
    private ?LocationPostTypeAPIInterface $locationPostTypeAPI = null;

    final public function setLocationPostTypeAPI(LocationPostTypeAPIInterface $locationPostTypeAPI): void
    {
        $this->locationPostTypeAPI = $locationPostTypeAPI;
    }
    final protected function getLocationPostTypeAPI(): LocationPostTypeAPIInterface
    {
        /** @var LocationPostTypeAPIInterface */
        return $this->locationPostTypeAPI ??= $this->instanceManager->getInstance(LocationPostTypeAPIInterface::class);
    }

    /**
     * @return mixed[]
     * @param array<string,mixed> $query
     * @param array<string,mixed> $options
     */
    public function executeQuery(array $query, array $options = []): array
    {
        return $this->getLocationPostTypeAPI()->getLocationPosts($query, $options);
    }
}
