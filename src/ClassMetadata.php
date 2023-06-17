<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata;

final readonly class ClassMetadata
{
    /**
     * @var class-string
     */
    private string $className;

    /**
     * @var list<PropertyMetadata>
     */
    private array $properties;

    /**
     * @param class-string $className
     * @param list<PropertyMetadata> $properties
     */
    public function __construct(string $className, array $properties)
    {
        $this->className = $className;
        $this->properties = $properties;
    }

    /**
     * @return class-string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return list<PropertyMetadata>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
