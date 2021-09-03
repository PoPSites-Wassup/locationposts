<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ConditionalOnComponent\Tags\FieldResolvers;

use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoPSchema\LocationPosts\FieldResolvers\AbstractLocationPostFieldResolver;

// use PoPSchema\LocationTags\TypeResolvers\LocationTagTypeResolver;

/**
 * Fields for event tags
 *
 * @author Leonardo Losoviz <leo@getpop.org>
 * @todo Create LocationTagTypeResolver class, then remove abstract
 */
abstract class LocationPostTagFieldResolver extends AbstractLocationPostFieldResolver
{
    // public function getClassesToAttachTo(): array
    // {
    //     return array(LocationTagTypeResolver::class);
    // }

    public function getSchemaFieldDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'locationposts' => $this->translationAPI->__('Location Posts which contain this tag', 'locationposts'),
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

        $query = parent::getQuery($relationalTypeResolver, $resultItem, $fieldName, $fieldArgs);

        $tag = $resultItem;
        switch ($fieldName) {
            case 'locationposts':
                $query['tag-ids'] = [$relationalTypeResolver->getID($tag)];
                break;
        }

        return $query;
    }
}
