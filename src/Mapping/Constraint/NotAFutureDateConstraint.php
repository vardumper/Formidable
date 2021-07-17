<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\Constraint\ValidationError;

class NotAFutureDateConstraint implements ConstraintInterface
{
    /**
     * @param mixed $value
     */
    public function __invoke($value) :  ValidationResult
    {
        if (empty($value) || is_null($value)) {
            return new ValidationResult();
        }

        // now
        $midnight = strtotime('today 23:59:59');

        // then
        $then = strtotime($value);

        if ($then > $midnight) {
            return new ValidationResult(new ValidationError('Not a valid date.'));
        }
        return new ValidationResult();
    }
}
