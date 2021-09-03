<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ConditionalOnComponent\Users\FieldResolvers;

use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoPSchema\LocationPosts\FieldResolvers\AbstractLocationPostFieldResolver;
use PoPSchema\Users\TypeResolvers\UserTypeResolver;

class LocationPostUserFieldResolver extends AbstractLocationPostFieldResolver
{
    public function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public function getSchemaFieldDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'locationposts' => $this->translationAPI->__('Location Posts by the user', 'locationposts'),
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

        $user = $resultItem;
        switch ($fieldName) {
            case 'locationposts':
                $query['authors'] = [$relationalTypeResolver->getID($user)];
                break;
        }

        return $query;
    }
}
