<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Constraint;

use Assert\Assertion;
use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\Constraint\ValidationError;

class FloatConstraint implements ConstraintInterface
{
    /**
     * @param mixed $value
     */
    public function __invoke($value) :  ValidationResult
    {
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
