<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\Constraint\ValidationError;
use vardumper\Formidable\Mapping\Constraint\Exception\InvalidTypeException;

class UrlWithProtocolConstraint implements ConstraintInterface
{
    /**
     * @param mixed $value
     */
    public function __invoke($value) :  ValidationResult
    {
        if (!is_string($value)) {
            throw InvalidTypeException::fromInvalidType($value, 'string');
        }
        
        /* no validation of empty strings */
        if (empty($value)) {
            return new ValidationResult();
        }
        $regex = "((https?)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor
        
        if (!preg_match("/^$regex$/i", $value)) { // `i` flag for case-insensitive
            return new ValidationResult(new ValidationError('Not a valid URL.'));
        }
        return new ValidationResult();
    }
}
