<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata\Tests;

use PHPUnit\Framework\TestCase;
use TunetLibs\PhpClassMetadata\PropertyMetadataFactory;
use TunetLibs\PhpClassMetadata\Tests\Fixtures\ReadonlyUser;
use TunetLibs\PhpClassMetadata\Tests\Fixtures\User;

final class PropertyMetadataFactoryTest extends TestCase
{
    private PropertyMetadataFactory $propertyMetadataFactory;

    public function testGetPropertyMetadata(): void
    {
        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'isAdmin');
        self::assertSame(User::class, $propertyMetadata->className);
        self::assertSame('isAdmin', $propertyMetadata->propertyName);
        self::assertSame('bool', $propertyMetadata->type);
        self::assertFalse($propertyMetadata->isNullable);
        self::assertFalse($propertyMetadata->isStatic);
        self::assertFalse($propertyMetadata->isReadonly);
        self::assertSame('PUBLIC', $propertyMetadata->visibility->value);
    }

    public function testNullableType(): void
    {
        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'firstName');
        self::assertTrue($propertyMetadata->isNullable);

        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'lastName');
        self::assertTrue($propertyMetadata->isNullable);

        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'isAdmin');
        self::assertFalse($propertyMetadata->isNullable);
    }

    public function testIsStatic(): void
    {
        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'middleName');
        self::assertTrue($propertyMetadata->isStatic);

        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'isAdmin');
        self::assertFalse($propertyMetadata->isStatic);
    }

    public function testIsReadonly(): void
    {
        $propertyMetadata = $this->propertyMetadataFactory->get(ReadonlyUser::class, 'firstName');
        self::assertTrue($propertyMetadata->isReadonly);

        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'readonlyProperty');
        self::assertTrue($propertyMetadata->isReadonly);

        $propertyMetadata = $this->propertyMetadataFactory->get(User::class, 'isAdmin');
        self::assertFalse($propertyMetadata->isReadonly);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->propertyMetadataFactory = new PropertyMetadataFactory();
    }
}
