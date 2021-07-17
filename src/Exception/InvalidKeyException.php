<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Exception;

use DomainException;

final class InvalidKeyException extends DomainException implements ExceptionInterface
{
    public static function fromArrayWithNonStringKeys(array $array)
    {
        return new self('Non-string key in array found');
    }

    public static function fromNonNestedKey($key)
    {
        return new self(sprintf('Expected string or nested integer key, but "%s" was provided', gettype($key)));
    }
}
