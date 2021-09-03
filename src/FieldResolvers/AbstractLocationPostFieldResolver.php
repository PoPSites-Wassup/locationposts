<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\FieldResolvers;

use PoP\ComponentModel\FieldResolvers\AbstractQueryableFieldResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoPSchema\LocationPosts\ComponentConfiguration;
use PoPSchema\LocationPosts\Facades\LocationPostTypeAPIFacade;
use PoPSchema\LocationPosts\TypeResolvers\LocationPostTypeResolver;
use PoPSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPSchema\SchemaCommons\Constants\QueryOptions;

abstract class AbstractLocationPostFieldResolver extends AbstractQueryableFieldResolver
{
    public function getFieldNamesToResolve(): array
    {
        return [
            'locationposts',
        ];
    }

    public function getSchemaFieldType(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): string
    {
        $types = [
            'locationposts' => SchemaDefinition::TYPE_ID,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($relationalTypeResolver, $fieldName);
    }

    public function getSchemaFieldTypeModifiers(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?int
    {
        return match ($fieldName) {
            'locationposts' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default => parent::getSchemaFieldTypeModifiers($relationalTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'locationposts' => $this->translationAPI->__('Location Posts', 'locationposts'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($relationalTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<string, mixed>
     */
    protected function getQuery(
        RelationalTypeResolverInterface $relationalTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = []
    ): array {
        switch ($fieldName) {
            case 'locationposts':
                return [
                    'limit' => ComponentConfiguration::getLocationPostListDefaultLimit(),
                ];
        }
        return [];
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        RelationalTypeResolverInterface $relationalTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        $locationPostTypeAPI = LocationPostTypeAPIFacade::getInstance();
        switch ($fieldName) {
            case 'locationposts':
                $query = array_merge(
                    $this->convertFieldArgsToFilteringQueryArgs($relationalTypeResolver, $fieldName, $fieldArgs),
                    $this->getQuery($relationalTypeResolver, $resultItem, $fieldName, $fieldArgs)
                );
                return $locationPostTypeAPI->getLocationPosts($query, [QueryOptions::RETURN_TYPE => ReturnTypes::IDS]);
        }

        return parent::resolveValue($relationalTypeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        switch ($fieldName) {
            case 'locationposts':
                return LocationPostTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($relationalTypeResolver, $fieldName);
    }
}
