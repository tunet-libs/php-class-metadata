<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata\Tests\Fixtures;

final class User
{
    public bool $isAdmin;
    public ?string $firstName;
    protected $lastName;
    private static string $middleName;
    private readonly string $readonlyProperty;
}
