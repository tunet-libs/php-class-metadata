<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata;

use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;

final readonly class PropertyMetadataFactory
{
    /**
     * @param class-string $className
     *
     * @throws ClassMetadataException
     */
    public function get(string $className, string $propertyName): PropertyMetadata
    {
        try {
            $reflectionProperty = new ReflectionProperty($className, $propertyName);
        } catch (ReflectionException $exception) {
            throw ClassMetadataException::createForUnhandledException($className, $exception);
        }

        $reflectionType = $reflectionProperty->getType();

        $type = $reflectionType instanceof ReflectionNamedType ? $reflectionType->getName() : null;
        $isNullable = $reflectionType?->allowsNull() ?? true;
        $isStatic = $reflectionProperty->isStatic();
        $isReadonly = $reflectionProperty->isReadOnly();
        $visibility = match (true) {
            $reflectionProperty->isPrivate() => VisibilityEnum::PRIVATE,
            $reflectionProperty->isProtected() => VisibilityEnum::PROTECTED,
            default => VisibilityEnum::PUBLIC,
        };

        return new PropertyMetadata($className, $propertyName, $type, $isNullable, $isStatic, $isReadonly, $visibility);
    }
}
