<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\TypeDataLoaders;

use PoPSchema\Posts\TypeDataLoaders\PostTypeDataLoader;
use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;

class LocationPostTypeDataLoader extends PostTypeDataLoader
{
    public function executeQuery($query, array $options = []): array
    {
        $locationPostTypeAPI = LocationPostTypeAPIFacade::getInstance();
        return $locationPostTypeAPI->getLocationPosts($query, $options);
    }
}
