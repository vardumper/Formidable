<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\Exception\InvalidTypeException;

final class EmailAddressConstraint implements ConstraintInterface
{
    public function __invoke($value) : ValidationResult
    {
        if (!is_string($value)) {
            throw InvalidTypeException::fromInvalidType($value, 'string');
        }

        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return new ValidationResult(new ValidationError('error.email-address'));
        }

        return new ValidationResult();
    }
}
