<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\Facades;

use PoP\Root\Container\ContainerBuilderFactory;
use PoPSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;

class LocationPostTypeAPIFacade
{
    public static function getInstance(): LocationPostTypeAPIInterface
    {
        /**
         * @var LocationPostTypeAPIInterface
         */
        $service = ContainerBuilderFactory::getInstance()->get(LocationPostTypeAPIInterface::class);
        return $service;
    }
}
