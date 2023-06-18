<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

use function array_map;
use function class_exists;
use function enum_exists;

final readonly class ClassMetadataFactory
{
    public function __construct(
        private PropertyMetadataFactory $propertyMetadataFactory,
    ) {
    }

    /**
     * @param class-string $className
     *
     * @throws ClassMetadataException
     */
    public function get(string $className): ClassMetadata
    {
        $reflectionClass = $this->getReflectionInstance($className);
        $reflectionProperties = $reflectionClass->getProperties();

        $listPropertyMetadata = array_map(
            fn(ReflectionProperty $property) => $this->propertyMetadataFactory->get($className, $property->getName()),
            $reflectionProperties,
        );

        return new ClassMetadata($className, $listPropertyMetadata);
    }

    /**
     * @param class-string $className
     *
     * @return ReflectionClass<object>
     *
     * @throws ClassMetadataException
     */
    private function getReflectionInstance(string $className): ReflectionClass
    {
        if (!class_exists($className, true)) {
            throw ClassMetadataException::createForNotFoundClass($className);
        }

        if (enum_exists($className, true)) {
            throw ClassMetadataException::createForEnumClass($className);
        }

        try {
            $classReflection = new ReflectionClass($className);
            // @phpstan-ignore-next-line
        } catch (ReflectionException $exception) {
            throw ClassMetadataException::createForUnhandledException($className, $exception);
        }

        if ($classReflection->isAbstract()) {
            throw ClassMetadataException::createForAbstractClass($className);
        }

        return $classReflection;
    }
}
