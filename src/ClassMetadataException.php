<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata;

use Exception;
use Throwable;

/**
 * @immutable
 */
final class ClassMetadataException extends Exception
{
    public function __construct(
        private readonly string $className,
        private readonly ErrorEnum $error,
        string $message = '',
        ?Throwable $previousException = null,
    ) {
        parent::__construct($message, 0, $previousException);
    }

    public static function createForNotFoundClass(string $className): self
    {
        return new self($className, ErrorEnum::CLASS_NOT_FOUND, "Class '{$className}' not found.");
    }

    public static function createForEnumClass(string $className): self
    {
        return new self(
            $className,
            ErrorEnum::CLASS_IS_ENUM,
            "Class '{$className}' is enum. Enum classes don't support.",
        );
    }

    public static function createForAbstractClass(string $className): self
    {
        return new self(
            $className,
            ErrorEnum::CLASS_IS_ABSTRACT,
            "Class '{$className}' is abstract. Abstract classes don't support.",
        );
    }

    public static function createForUnhandledException(string $className, Throwable $exception): self
    {
        return new self(
            $className,
            ErrorEnum::UNHANDLED_CLASS_METADATA,
            "Unhandled class '{$className}' exception.",
            $exception,
        );
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getError(): ErrorEnum
    {
        return $this->error;
    }
}
