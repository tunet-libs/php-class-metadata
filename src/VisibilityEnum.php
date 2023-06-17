<?php

declare(strict_types=1);

namespace TunetLibs\ClassMetadata;

enum VisibilityEnum: string
{
    case PUBLIC = 'PUBLIC';
    case PROTECTED = 'PROTECTED';
    case PRIVATE = 'PRIVATE';
}
