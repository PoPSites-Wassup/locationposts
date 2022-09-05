<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts;

use PoP\Root\Module\ModuleInterface;
use PoP\Root\Module\AbstractModule;
use PoPCMSSchema\Tags\Module as TagsModule;
use PoPCMSSchema\Users\Module as UsersModule;

class Module extends AbstractModule
{
    /**
     * @return array<class-string<ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \PoPCMSSchema\Posts\Module::class,
        ];
    }

    /**
     * @return array<class-string<ModuleInterface>>
     */
    public function getDependedConditionalModuleClasses(): array
    {
        return [
            \PoPCMSSchema\Users\Module::class,
            \PoPCMSSchema\Tags\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param array<class-string<ModuleInterface>> $skipSchemaModuleClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaModuleClasses,
    ): void {
        $this->initSchemaServices(dirname(__DIR__), $skipSchema);

        if (Environment::addLocationPostTypeToCustomPostUnionTypes()) {
            $this->initSchemaServices(dirname(__DIR__), $skipSchema, '/ConditionalOnContext/AddLocationPostTypeToCustomPostUnionTypes');
        }

        if (class_exists(TagsModule::class)) {
            $this->initSchemaServices(
                dirname(__DIR__),
                $skipSchema || in_array(\PoPCMSSchema\Tags\Module::class, $skipSchemaModuleClasses),
                '/ConditionalOnModule/Tags'
            );
        }

        if (class_exists(UsersModule::class)) {
            $this->initSchemaServices(
                dirname(__DIR__),
                $skipSchema || in_array(UsersModule::class, $skipSchemaModuleClasses),
                '/ConditionalOnModule/Users'
            );
        }
    }
}
