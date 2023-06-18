<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata;

final readonly class PropertyMetadata
{
    /**
     * @var class-string
     */
    public string $className;

    /**
     * @param class-string $className
     */
    public function __construct(
        string $className,
        public string $propertyName,
        public ?string $type,
        public bool $isNullable,
        public bool $isStatic,
        public bool $isReadonly,
        public VisibilityEnum $visibility,
    ) {
        $this->className = $className;
    }
}
