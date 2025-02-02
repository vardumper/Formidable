<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Exception;

use DomainException;

final class InvalidValueException extends DomainException implements ExceptionInterface
{
    public static function fromArrayWithNonStringValues(array $array)
    {
        return new self('Non-string value in array found');
    }

    public static function fromNonNestedValue($value)
    {
        return new self(sprintf('Expected string or array value, but "%s" was provided', gettype($value)));
    }
}
