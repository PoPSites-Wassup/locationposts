<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\ConditionalOnComponent\Users\FieldResolvers\ObjectType;

use PoP\Translation\TranslationAPIInterface;
use PoP\Hooks\HooksAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use PoP\LooseContracts\NameResolverInterface;
use PoP\Engine\CMS\CMSServiceInterface;
use PoP\ComponentModel\HelperServices\SemverHelperServiceInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\LocationPosts\FieldResolvers\ObjectType\AbstractLocationPostObjectTypeFieldResolver;
use PoPSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

class LocationPostUserObjectTypeFieldResolver extends AbstractLocationPostObjectTypeFieldResolver
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            UserObjectTypeResolver::class,
        ];
    }

    public function getSchemaFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'locationposts' => $this->translationAPI->__('Location Posts by the user', 'locationposts'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($objectTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @return array<string, mixed>
     */
    protected function getQuery(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = []
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
