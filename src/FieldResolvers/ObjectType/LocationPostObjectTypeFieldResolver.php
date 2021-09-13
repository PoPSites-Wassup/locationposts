<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\FieldResolvers\ObjectType;

use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\LocationPosts\TypeResolvers\ObjectType\LocationPostObjectTypeResolver;
use PoPSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPSchema\Taxonomies\Facades\TaxonomyTypeAPIFacade;
use PoPSchema\SchemaCommons\Constants\QueryOptions;

class LocationPostObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            LocationPostObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'categories',
            'catSlugs',
            'catName',
        ];
    }

    public function getSchemaFieldType(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): string
    {
        return match ($fieldName) {
            'catSlugs' => SchemaDefinition::TYPE_STRING,
            'catName' => SchemaDefinition::TYPE_STRING,
            default => parent::getSchemaFieldType($objectTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?int
    {
        return match ($fieldName) {
            'categories', 'catSlugs' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default => parent::getSchemaFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'categories' => $this->translationAPI->__('', ''),
            'catSlugs' => $this->translationAPI->__('', ''),
            'catName' => $this->translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($objectTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        $taxonomyapi = TaxonomyTypeAPIFacade::getInstance();
        $locationpost = $object;
        switch ($fieldName) {
            case 'categories':
                return $taxonomyapi->getCustomPostTaxonomyTerms(
                    $objectTypeResolver->getID($locationpost),
                    POP_LOCATIONPOSTS_TAXONOMY_CATEGORY,
                    [
                        QueryOptions::RETURN_TYPE => ReturnTypes::IDS,
                    ]
                );

            case 'catSlugs':
                return $taxonomyapi->getCustomPostTaxonomyTerms(
                    $objectTypeResolver->getID($locationpost),
                    POP_LOCATIONPOSTS_TAXONOMY_CATEGORY,
                    [
                        QueryOptions::RETURN_TYPE => ReturnTypes::SLUGS,
                    ]
                );

            case 'catName':
                $cat = $objectTypeResolver->resolveValue($object, 'mainCategory', $variables, $expressions, $options);
                if (GeneralUtils::isError($cat)) {
                    return $cat;
                } elseif ($cat) {
                    return $taxonomyapi->getTermName($cat, POP_LOCATIONPOSTS_TAXONOMY_CATEGORY);
                }
                return null;
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
