<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\RelationalTypeDataLoaders\Object;

use PoPSchema\Posts\RelationalTypeDataLoaders\Object\PostTypeDataLoader;
use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;

class LocationPostTypeDataLoader extends PostTypeDataLoader
{
    public function executeQuery($query, array $options = []): array
    {
        $locationPostTypeAPI = LocationPostTypeAPIFacade::getInstance();
        return $locationPostTypeAPI->getLocationPosts($query, $options);
    }
}
