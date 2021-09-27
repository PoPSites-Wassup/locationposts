<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\RelationalTypeDataLoaders\ObjectType;

use PoP\Hooks\HooksAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\LooseContracts\NameResolverInterface;
use PoP\ComponentModel\ModuleProcessors\ModuleProcessorManagerInterface;
use PoPSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;
use PoPSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;
use PoPSchema\Posts\RelationalTypeDataLoaders\ObjectType\PostTypeDataLoader;
use PoPSchema\Posts\TypeAPIs\PostTypeAPIInterface;

class LocationPostTypeDataLoader extends PostTypeDataLoader
{
    public function __construct(
        HooksAPIInterface $hooksAPI,
        InstanceManagerInterface $instanceManager,
        NameResolverInterface $nameResolver,
        ModuleProcessorManagerInterface $moduleProcessorManager,
        CustomPostTypeAPIInterface $customPostTypeAPI,
        PostTypeAPIInterface $postTypeAPI,
        protected LocationPostTypeAPIInterface $locationPostTypeAPI,
    ) {
        parent::__construct(
            $hooksAPI,
            $instanceManager,
            $nameResolver,
            $moduleProcessorManager,
            $customPostTypeAPI,
            $postTypeAPI,
        );
    }

    public function executeQuery($query, array $options = []): array
    {
        return $this->locationPostTypeAPI->getLocationPosts($query, $options);
    }
}
