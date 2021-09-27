<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\TypeResolvers\ObjectType;

use PoP\ComponentModel\Engine\DataloadingEngineInterface;
use PoP\ComponentModel\AttachableExtensions\AttachableExtensionManagerInterface;
use PoP\ComponentModel\DirectivePipeline\DirectivePipelineServiceInterface;
use PoP\Translation\TranslationAPIInterface;
use PoP\Hooks\HooksAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\Schema\SchemaNamespacingServiceInterface;
use PoP\ComponentModel\Schema\SchemaDefinitionServiceInterface;
use PoP\ComponentModel\Schema\FeedbackMessageStoreInterface;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use PoP\ComponentModel\ErrorHandling\ErrorProviderInterface;
use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoPSchema\LocationPosts\Environment;
use PoPSchema\Posts\TypeResolvers\ObjectType\PostObjectTypeResolver;
use PoPSchema\LocationPosts\RelationalTypeDataLoaders\ObjectType\LocationPostTypeDataLoader;

class LocationPostObjectTypeResolver extends PostObjectTypeResolver
{
    protected ?string $name = null;

    public function __construct(
        TranslationAPIInterface $translationAPI,
        HooksAPIInterface $hooksAPI,
        InstanceManagerInterface $instanceManager,
        SchemaNamespacingServiceInterface $schemaNamespacingService,
        SchemaDefinitionServiceInterface $schemaDefinitionService,
        AttachableExtensionManagerInterface $attachableExtensionManager,
        FeedbackMessageStoreInterface $feedbackMessageStore,
        FieldQueryInterpreterInterface $fieldQueryInterpreter,
        ErrorProviderInterface $errorProvider,
        DataloadingEngineInterface $dataloadingEngine,
        DirectivePipelineServiceInterface $directivePipelineService,
        protected LocationPostTypeDataLoader $locationPostTypeDataLoader,
    ) {
        parent::__construct(
            $translationAPI,
            $hooksAPI,
            $instanceManager,
            $schemaNamespacingService,
            $schemaDefinitionService,
            $attachableExtensionManager,
            $feedbackMessageStore,
            $fieldQueryInterpreter,
            $errorProvider,
            $dataloadingEngine,
            $directivePipelineService,
        );
    }

    public function getTypeName(): string
    {
        if ($this->name === null) {
            $this->name = Environment::getLocationPostTypeName() ?? 'LocationPost';
        }
        return $this->name;
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('A post which has locations', 'locationposts');
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->locationPostTypeDataLoader;
    }
}
