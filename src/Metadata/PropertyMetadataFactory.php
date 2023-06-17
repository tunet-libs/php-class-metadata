<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata\Metadata;

use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use TunetLibs\PhpClassMetadata\ClassMetadataException;
use TunetLibs\PhpClassMetadata\PropertyMetadata;
use TunetLibs\PhpClassMetadata\VisibilityEnum;

/**
 * @internal
 */
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
        $visibility = match (true) {
            $reflectionProperty->isPrivate() => VisibilityEnum::PRIVATE,
            $reflectionProperty->isProtected() => VisibilityEnum::PROTECTED,
            default => VisibilityEnum::PUBLIC,
        };

        return new PropertyMetadata($className, $propertyName, $type, $isNullable, $isStatic, $visibility);
    }
}
