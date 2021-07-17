<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Constraint;

interface ConstraintInterface
{
    /**
     * @param mixed $value
     */
    public function __invoke($value) : ValidationResult;
}
