<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\Constraint\ValidationError;
use vardumper\Formidable\Mapping\Constraint\Exception\InvalidTypeException;

class FloatConstraint implements ConstraintInterface
{
    /**
     * @param mixed $value
     */
    public function __invoke($value) :  ValidationResult
    {
        if (!is_float($value) && !is_double($value) && !is_real($value)) {
            throw InvalidTypeException::fromInvalidType($value, 'float|double|real');
        }
        /* no validation of empty or null */
        if (empty($value) || is_null($value)) {
            return new ValidationResult();
        }
        $clean = preg_replace('/[^\\d.]+/', '', $value);
        if (strlen($clean) === 0 || empty($clean)) {
            return new ValidationResult(new ValidationError('Not a valid decimal.'));
        }
        $value = (float) $value;
        if (!is_numeric($value)) {
            return new ValidationResult(new ValidationError('Not a valid decimal.'));
        }
        return new ValidationResult();
    }
}
