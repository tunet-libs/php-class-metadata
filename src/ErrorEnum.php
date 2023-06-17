<?php

declare(strict_types=1);

namespace TunetLibs\PhpClassMetadata;

enum ErrorEnum: string
{
    case CLASS_NOT_FOUND = 'CLASS_NOT_FOUND';
    case CLASS_IS_ENUM = 'CLASS_IS_ENUM';
    case CLASS_IS_ABSTRACT = 'CLASS_IS_ABSTRACT';
    case UNHANDLED_CLASS_METADATA = 'UNHANDLED_CLASS_METADATA';
}
