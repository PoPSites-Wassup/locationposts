<?php

declare(strict_types=1);

namespace PoPCMSSchema\LocationPosts\ConditionalOnModule\Users\FieldResolvers\ObjectType;

use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPCMSSchema\LocationPosts\FieldResolvers\ObjectType\AbstractLocationPostObjectTypeFieldResolver;
use PoPCMSSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

class LocationPostUserObjectTypeFieldResolver extends AbstractLocationPostObjectTypeFieldResolver
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            UserObjectTypeResolver::class,
        ];
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'locationposts' => $this->__('Location Posts by the user', 'locationposts'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<string, mixed>
     */
    protected function getQuery(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs
    ): array {

        $query = parent::getQuery($objectTypeResolver, $object, $fieldName, $fieldArgs);

        $user = $object;
        switch ($fieldName) {
            case 'locationposts':
                $query['authors'] = [$objectTypeResolver->getID($user)];
                break;
        }

        return $query;
    }
}
