<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\FieldResolvers;

use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\Engine\TypeResolvers\RootTypeResolver;
use PoPSchema\LocationPosts\FieldResolvers\AbstractLocationPostFieldResolver;

class RootLocationPostFieldResolver extends AbstractLocationPostFieldResolver
{
    public function getClassesToAttachTo(): array
    {
        return array(RootTypeResolver::class);
    }

    public function getSchemaFieldDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        $descriptions = [
            'posts' => $this->translationAPI->__('Location Posts in the current site', 'locationposts'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($relationalTypeResolver, $fieldName);
    }
}
