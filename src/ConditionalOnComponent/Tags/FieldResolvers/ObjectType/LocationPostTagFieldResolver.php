<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ConditionalOnComponent\Tags\FieldResolvers\ObjectType;

use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\LocationPosts\FieldResolvers\ObjectType\AbstractLocationPostFieldResolver;

// use PoPSchema\LocationTags\TypeResolvers\ObjectType\LocationTagTypeResolver;

/**
 * Fields for event tags
 *
 * @author Leonardo Losoviz <leo@getpop.org>
 * @todo Create LocationTagTypeResolver class, then remove abstract
 */
abstract class LocationPostTagFieldResolver extends AbstractLocationPostFieldResolver
{
    // public function getObjectTypeResolverClassesToAttachTo(): array
    // {
    //     return array(LocationTagTypeResolver::class);
    // }

    public function getSchemaFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'locationposts' => $this->translationAPI->__('Location Posts which contain this tag', 'locationposts'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($objectTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<string, mixed>
     */
    protected function getQuery(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = []
    ): array {

        $query = parent::getQuery($objectTypeResolver, $resultItem, $fieldName, $fieldArgs);

        $tag = $resultItem;
        switch ($fieldName) {
            case 'locationposts':
                $query['tag-ids'] = [$objectTypeResolver->getID($tag)];
                break;
        }

        return $query;
    }
}
