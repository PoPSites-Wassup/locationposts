<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts\FieldResolvers\ObjectType;

use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\Root\App;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractQueryableObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPCMSSchema\LocationPosts\Module;
use PoPCMSSchema\LocationPosts\ModuleConfiguration;
use PoPCMSSchema\LocationPosts\TypeAPIs\LocationPostTypeAPIInterface;
use PoPCMSSchema\LocationPosts\TypeResolvers\ObjectType\LocationPostObjectTypeResolver;
use PoPSchema\SchemaCommons\Constants\QueryOptions;
use PoPCMSSchema\SchemaCommons\DataLoading\ReturnTypes;

abstract class AbstractLocationPostObjectTypeFieldResolver extends AbstractQueryableObjectTypeFieldResolver
{
    private ?LocationPostObjectTypeResolver $locationPostObjectTypeResolver = null;
    private ?LocationPostTypeAPIInterface $locationPostTypeAPI = null;

    final public function setLocationPostObjectTypeResolver(LocationPostObjectTypeResolver $locationPostObjectTypeResolver): void
    {
        $this->locationPostObjectTypeResolver = $locationPostObjectTypeResolver;
    }
    final protected function getLocationPostObjectTypeResolver(): LocationPostObjectTypeResolver
    {
        return $this->locationPostObjectTypeResolver ??= $this->instanceManager->getInstance(LocationPostObjectTypeResolver::class);
    }
    final public function setLocationPostTypeAPI(LocationPostTypeAPIInterface $locationPostTypeAPI): void
    {
        $this->locationPostTypeAPI = $locationPostTypeAPI;
    }
    final protected function getLocationPostTypeAPI(): LocationPostTypeAPIInterface
    {
        return $this->locationPostTypeAPI ??= $this->instanceManager->getInstance(LocationPostTypeAPIInterface::class);
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'locationposts',
        ];
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'locationposts' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'locationposts' => $this->__('Location Posts', 'locationposts'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<string, mixed>
     */
    protected function getQuery(ObjectTypeResolverInterface $objectTypeResolver, object $object, string $fieldName, array $fieldArgs): array
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        return match ($fieldName) {
            'locationposts' => [
                'limit' => $moduleConfiguration->getLocationPostListDefaultLimit(),
            ],
            default => [],
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed> $variables
     * @param array<string, mixed> $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs,
        array $variables,
        array $expressions,
        \PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface $field,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
        array $options = []
    ): mixed {
        switch ($fieldName) {
            case 'locationposts':
                $query = array_merge(
                    $this->convertFieldArgsToFilteringQueryArgs($objectTypeResolver, $fieldName, $fieldArgs),
                    $this->getQuery($objectTypeResolver, $object, $fieldName, $fieldArgs)
                );
                return $this->getLocationPostTypeAPI()->getLocationPosts($query, [QueryOptions::RETURN_TYPE => ReturnTypes::IDS]);
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $field, $objectTypeFieldResolutionFeedbackStore, $options);
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'locationposts' => $this->getLocationPostObjectTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }
}
